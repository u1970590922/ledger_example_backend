# 簡單記帳系統-後端(Laravel)
基本讀取、新增、編輯、刪除功能(RESTful API)

## 準備

### 需求
- PHP: `v8.1.5`
- mysql: `v8.0.28`
- Composer: `v2.3.5`
- Laravel: `v9.10.1`

### 安裝
把 `.env.example`，改檔名為 `.env` 

- 初始化
```
composer install 
```
```
npm install
```

- 自動設置 APP_KEY 

```
php artisan key:generate
```

創建名為`ledger_app`的資料庫

- 創建資料表與假資料
```
php artisan migrate --seed
```

- 開啟簡易本地伺服器

```
php artisan serve
```

## 其他

### 登入驗證服務
- 增加登入(login)
- 增加登出(logout)
- 其他待開發