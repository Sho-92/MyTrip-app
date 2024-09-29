import './bootstrap';
import { createApp } from 'vue';

// Vueアプリを作成してマウント
const app = createApp({
    data() {
        return {
            checklists: [] // チェックリストのデータ
        };
    },
    mounted() {
        const addChecklistModal = document.getElementById('addChecklistModal');
        const form = addChecklistModal.querySelector('form');

        // モーダルを開くボタンにイベントリスナーを追加
        const modalButtons = document.querySelectorAll('.modal-button-class'); // モーダルを開くボタンのクラス名に置き換えてください

        modalButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                const itemId = button.getAttribute('data-item-id'); // データ属性からIDを取得
                const actionType = button.getAttribute('data-action-type'); // データ属性からアクションタイプを取得
                const form = document.getElementById(`${actionType}Form`); // アクションタイプに応じたフォームを取得

                // フォームのアクションを設定
                if (form) {
                    form.action = `/${actionType}/${itemId}`;
                }

                // モーダルを表示
                const modal = new bootstrap.Modal(addChecklistModal);
                modal.show();

                // フォームの送信イベントを処理
                form.addEventListener('submit', function(e) {
                    e.preventDefault(); // デフォルトのフォーム送信を防ぐ

                    const formData = new FormData(form);
                    const actionUrl = form.getAttribute('action');

                    fetch(actionUrl, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // モーダルを閉じる
                        const modalInstance = bootstrap.Modal.getInstance(addChecklistModal);
                        modalInstance.hide(); // Bootstrapのモーダルを閉じる

                        // 新しいチェックリストをタブに追加
                        const myTab = document.getElementById('myTab');
                        const tabContent = document.querySelector('.tab-content');

                        // 既存のアクティブなタブとコンテンツを無効にする
                        const activeTab = myTab.querySelector('.active');
                        const activePane = tabContent.querySelector('.tab-pane.show.active');
                        if (activeTab) activeTab.classList.remove('active');
                        if (activePane) {
                            activePane.classList.remove('show', 'active');
                        }

                        // 新しいタブのボタンを作成
                        const newTabButton = document.createElement('button');
                        newTabButton.classList.add('nav-link', 'active'); // 新しいタブをアクティブにする
                        newTabButton.setAttribute('data-bs-toggle', 'tab');
                        newTabButton.setAttribute('data-bs-target', `#${data.id}`);
                        newTabButton.type = 'button';
                        newTabButton.textContent = data.title;

                        myTab.appendChild(newTabButton);

                        // 新しいタブのコンテンツを作成
                        const newTabPane = document.createElement('div');
                        newTabPane.classList.add('tab-pane', 'fade', 'show', 'active'); // 新しいコンテンツをアクティブにする
                        newTabPane.id = data.id;

                        const heading = document.createElement('h3');
                        heading.textContent = data.title;
                        newTabPane.appendChild(heading);

                        const ul = document.createElement('ul');
                        ul.classList.add('list-group');
                        newTabPane.appendChild(ul);

                        tabContent.appendChild(newTabPane);
                    })
                    .catch(error => {
                        console.error('エラーが発生しました:', error);
                        alert('エラーが発生しました。');
                    });
                });
            });
        });


    }
});

app.mount('#app'); // Vueアプリを #app 要素にマウント


// Google Mapsのスクリプトを非同期で読み込む
window.onload = function() {
    console.log("ページが読み込まれました。"); // デバッグ用メッセージ

    const script = document.createElement('script');
    script.src = `https://maps.googleapis.com/maps/api/js?key={{ config('services.google.api_key') }}&libraries=places&callback=initializeGoogleMaps`;
    script.async = true; // 非同期でスクリプトをロード
    script.onload = function() {
        console.log("Google Maps APIのスクリプトが読み込まれました。");
    };
    script.onerror = function() {
        console.error("Google Maps APIの読み込み中にエラーが発生しました。");
    };
    document.head.appendChild(script);
};

// Google Maps APIの初期化関数
function initializeGoogleMaps() {
    try {
        const addressInput = document.getElementById('address');
        if (!addressInput) throw new Error('Address input not found');

        // Autocomplete 機能をGoogle Maps APIから使用
        const autocomplete = new google.maps.places.Autocomplete(addressInput);
        autocomplete.addListener('place_changed', function() {
            const place = autocomplete.getPlace();
            console.log('Selected place:', place);
        });
    } catch (error) {
        console.error('Google Maps initialization failed:', error.message);
    }
}


