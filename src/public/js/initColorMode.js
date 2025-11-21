/**
 * カラーモード対応
 * 指定しなければOS設定のモードを適用
 * 選択したモードはローカルストレージに保存される
 */
export function initColorMode() {
  const html = document.documentElement;

  // OS設定にのカラーモード（light or dark）を取得
  function getOSColorMode() {
    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
  }

  // modeがautoならOS設定、そうでなければmodeを適用してローカルストレージに保存
  function applyTheme(mode, btns) {
    const theme = mode === 'auto' ? getOSColorMode(): mode;
    html.setAttribute('data-bs-theme', theme);

    if (mode === 'auto') {
      localStorage.removeItem('theme');
    } else {
      localStorage.setItem('theme', mode)
    }

    applyIconByTheme(theme);
    setClassByMode(mode, btns);
  }


  // ドロップダウンメニューの各カラーモード選択肢のアイコンを取得する
  function getIcon(theme) {
      const icon = document.querySelector(`#theme-${theme} svg`);
      const svg = icon.cloneNode();
      Array.from(icon.children).forEach(child => svg.append(child.cloneNode()));
      return svg;
  }

  // テーマに応じてドロップダウンボタンのアイコンを変更する
  function applyIconByTheme(theme) {
    const icon = getIcon(theme);
    const button = document.getElementById('themeDropdown');
    const iconWrapper = button.querySelector('.theme-icon');
    iconWrapper.innerHTML = '';
    iconWrapper.append(icon);
  }

  // アクティブなボタンにクラスを付与
  function setClassByMode(mode, btns) {
    Object.keys(btns).forEach(m => {
      btns[m].classList.toggle('active', m === mode);
    })
  }


  const mode = localStorage.getItem('theme') ?? 'auto'; // light|dark|auto

  // 切り替えボタン
  const btns = {
    light: document.getElementById('theme-light'),
    dark: document.getElementById('theme-dark'),
    auto: document.getElementById('theme-auto'),
  }

  // 初期適用
  applyTheme(mode, btns);

  // 切り替えボタンの動作
  Object.keys(btns).forEach(m => {
    btns[m].addEventListener('click', () => applyTheme(m, btns));
  });
};