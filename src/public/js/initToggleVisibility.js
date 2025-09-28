/**
 * ラジオボタン切り替えでターゲット要素を表示/非表示する初期化関数
 *
 * @param {string} [selector='.toggle-input'] 対象のラジオボタンのセレクタ
 */
export function initToggleVisibility(selector = '.toggle-input') {
    const toggleInputs = document.querySelectorAll(selector);
    
    // name属性ごとにグループ化
    const groupedByName = {};
    toggleInputs.forEach(input => {
        const name = input.name;
        if (!groupedByName[name]) {
            groupedByName[name] = [];
        }
        groupedByName[name].push(input);
    })

    Object.values(groupedByName).forEach(nameGroup => {
        // イベントを仕込む
        nameGroup.forEach(input => {
            input.addEventListener('change', () => updateGroupVisibility(nameGroup))
        });

        // 初期状態の表示を反映
        updateGroupVisibility(nameGroup);
    })
}


/**
 * グループ内の表示切替
 *
 * @param {HTMLElement[]} nameGroup
 */
function updateGroupVisibility(nameGroup) {
    // グループ内の全てのtargetを非表示
    nameGroup.forEach(groupInput => {
        const groupTargets = document.querySelectorAll(groupInput.dataset.toggleTarget);
        groupTargets.forEach(target => {
            undisplayTarget(target);
        })
    })

    // 選択されたものだけ表示
    const checked = nameGroup.find(input => input.checked);
    if (checked) {
        const targets = document.querySelectorAll(checked.dataset.toggleTarget);
        targets.forEach(target => {
            target.style.display = '';
        })
    }
}


/**
 * ターゲット要素を非表示にして、内部のinputをクリア
 *
 * @param {HTMLElement} target 
 */
function undisplayTarget(target) {
    // 非表示
    target.style.display = 'none';
    // 値のクリア
    Array.from(target.getElementsByTagName('input')).forEach(input => {
        // value
        input.value = '';

        // チェックボックス/ラジオ
        if (input.type === 'checkbox' || input.type === 'radio') {
            input.checked = false;
        }
    });

    // textareaのクリア
    Array.from(target.getElementsByTagName('textarea')).forEach(textarea => {
        textarea.value = '';
    });

    // セレクトボックスのクリア
    Array.from(target.getElementsByTagName('select')).forEach(select => {
        Array.from(select.options).forEach(option => {
            option.selected = false;
        })
    });
}