import './bootstrap';
import { createApp } from 'vue';

// Vueアプリを作成してマウント
const app = createApp({
    mounted() {
        // 共通の削除モーダルの表示イベント
        $('.modal').on('show.bs.modal', function (event) {
            const button = event.relatedTarget; // モーダルを開いたボタン
            const itemId = button.getAttribute('data-item-id'); // データ属性からIDを取得
            const actionType = button.getAttribute('data-action-type'); // データ属性からアクションタイプを取得
            const form = document.getElementById(`${actionType}Form`); // アクションタイプに応じたフォームを取得

            // フォームのアクションを設定
            if (form) {
                form.action = `/${actionType}/${itemId}`;
            }
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


