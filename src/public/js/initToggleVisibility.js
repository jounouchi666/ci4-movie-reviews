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

function updateGroupVisibility(nameGroup) {
    // グループ内の全てのtargetを非表示
    nameGroup.forEach(groupInput => {
        const groupTargets = document.querySelectorAll(groupInput.dataset.toggleTarget);
        groupTargets.forEach(target => {
            target.style.display = 'none';
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