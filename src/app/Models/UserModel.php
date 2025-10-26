<?php

namespace App\Models;

use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;
use App\Entities\User;
use CodeIgniter\HTTP\Files\UploadedFile;
use Config\Services;

/**
 * UserModel（ShieldのUserModelの拡張）
 */
class UserModel extends ShieldUserModel
{
    protected $returnType = User::class;

    protected $allowedFields = ['icon_path'];

    // ユーザーアイコンのディレクトリ
    protected const ICON_DIR = FCPATH . USER_ICON_DIR;

    // サムネイルサイズ
    protected const THUMB_SIZES = [120, 100];

    public function __construct()
    {
        parent::__construct();

        // 継承元のallowedFieldsをマージ
        $parentFields = get_class_vars(get_parent_class($this))['allowedFields'];
        $this->allowedFields = array_merge($parentFields, $this->allowedFields);
    }


    /**
     * ファイルを旧ファイルと置き換えて保存し、パスをテーブルに書き込む
     *
     * @param int $userId ユーザーID
     * @param UploadedFile $file 保存するファイル
     * @return string ファイル名
     */
    public function saveIcon($userId, $file):string
    {
        $fileName = $userId . '_' . time() . '.' . $file->getExtension();
        $user = $this->find($userId);

        // 旧ファイルの削除
        if ($user && $user->icon_path) {
            $oldFile = $user->icon_path;
            $oldFilePath = self::ICON_DIR . $oldFile;
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
            foreach (self::THUMB_SIZES as $size) {
                $this->deleteThumb($oldFile, $size);
            }
        }

        // ファイルの保存
        $file->move(self::ICON_DIR, $fileName, true);

        // 縮小サイズファイルの保存
        foreach (self::THUMB_SIZES as $size) {
            $this->saveThumb($fileName, $size);
        }

        // DB更新
        $this->update($userId, ['icon_path' => $fileName]);

        return $fileName;
    }


    /**
     * リサイズファイルを保存する
     *
     * @param string $fileName ファイル名
     * @param int|string $width リサイズファイルの横幅
     * @param int|string $height リサイズファイルの高さ（省略で横幅と同じにする）
     * @return bool
     */
    private function saveThumb($fileName, $width, $height = null): bool
    {
        $filePath = self::ICON_DIR . $fileName;
        $fileNameResized = $this->getResizedFileName($fileName, $width);

        $thumbPath = self::ICON_DIR . $fileNameResized;
        
        return Services::image()
                ->withFile($filePath)
                ->resize($width, $height ?? $width, true)
                ->save($thumbPath);
    }


    /**
     * リサイズファイルを削除する
     *
     * @param string $fileName ファイル名
     * @param int|string $width リサイズファイルの横幅
     * @return bool
     */
    private function deleteThumb($fileName, $width): bool
    {
        $oldFile = $this->getResizedFileName($fileName, $width);
        if (file_exists($oldFile)) {
            return unlink($oldFile);
        }
        return false;
    }


    /**
     * リサイズファイル名を取得する
     *
     * @param string $fileName ファイル名
     * @param int|string $width リサイズファイルの横幅
     * @return string ファイル名
     */
    private function getResizedFileName($fileName, $width): string
    {
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        $base = pathinfo($fileName, PATHINFO_FILENAME);
        return $base . '_' . $width . '.' . $ext;
    }
}