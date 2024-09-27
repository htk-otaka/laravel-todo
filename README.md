# artisanコマンド
1. マイグレーションファイルの作成
```
php artisan make:migration add_user_id_to_folders --table=folders
```

2. マイグレーションの実行
```
php artisan migrate
```

3. 全テーブル削除後、マイグレーション
```
php artisan migrate:fresh
```

4. シーダーの作成
```
php artisan make:seeder UsersTableSeeder
```

5. シーダーの実行（まとめて）
```
php artisan db:seed
```

6. シーダーの実行（個別）
```
php artisan db:seed --class=UsersTableSeeder
```

7. FormRequestクラスの作成
バリデーションに利用。
```
php artisan make:request CreateTask
```

8. テストコードの作成
```
php artisan make:test TaskTest
```

9. ポリシークラスの作成
```
php artisan make:policy FolderPolicy
```

9. プロバイダーの作成
```
php artisan make:provider RiakServiceProvider
```
