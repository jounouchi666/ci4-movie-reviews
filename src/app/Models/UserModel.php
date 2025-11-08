<?php

namespace App\Models;

use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;
use App\Entities\User;
use App\Traits\UserIconTrait;
use CodeIgniter\HTTP\Files\UploadedFile;
use Config\Services;

/**
 * UserModel（ShieldのUserModelの拡張）
 */
class UserModel extends ShieldUserModel
{
    use UserIconTrait;

    protected $returnType = User::class;

    protected $allowedFields = ['icon_path'];

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    public function __construct()
    {
        parent::__construct();

        // 継承元のallowedFieldsをマージ
        $parentFields = get_class_vars(get_parent_class($this))['allowedFields'];
        $this->allowedFields = array_merge($parentFields, $this->allowedFields);
    }


    /**
     * パスワードをハッシュ化して保存する（beforeInsert / beforeUpdate用）
     *
     * @param array $data モデルイベントに渡されるデータ配列
     * @return array 加工後のデータ配列
     */
    protected function hashPassword($data)
    {
        if (!empty($data['data']['password'])) {
            $data['data']['password_hash'] = service('passwords')->hash($data['data']['password']);
            unset($data['data']['password']);
        }
        return $data;
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
}