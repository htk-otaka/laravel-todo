# 概要
laravelの学習で、ToDoアプリを作成いたしました。

# 環境構築手順
1. リポジトリをクローン。
```
git clone https://github.com/htk-otaka/laravel-todo.git
```
2. envファイルの作成
```
cp .env.example .env
```
3. コンテナのビルドと起動
```
docker compose up -d --build
```
以下のように５つのコンテナが起動していればOK
```
docker compose ps

CONTAINER ID   IMAGE                      COMMAND                   CREATED         STATUS         PORTS                               NAMES
a55bb8b70296   laravel-todo-nginx         "/docker-entrypoint.…"   3 minutes ago   Up 3 minutes   0.0.0.0:80->80/tcp                  laravel-nginx
03866e3af6c1   laravel-todo-laravel-app   "bash -c 'composer i…"   3 minutes ago   Up 3 minutes   0.0.0.0:5173->5173/tcp, 9000/tcp    laravel-app
a0a2235cb401   redis:alpine               "docker-entrypoint.s…"   3 minutes ago   Up 3 minutes   0.0.0.0:16379->6379/tcp             laravel-redis
ce65e7ffb521   mysql:8.4                  "docker-entrypoint.s…"   3 minutes ago   Up 3 minutes   0.0.0.0:3306->3306/tcp, 33060/tcp   laravel-mysql
6f112bd149d9   mailhog/mailhog            "MailHog"                 3 minutes ago   Up 3 minutes   1025/tcp, 0.0.0.0:8025->8025/tcp    mailhog
```
4. laravel-appコンテナに入り、マイグレーションを実行
```
docker compose exec laravel-app bash
php artisan migrate
```
5. [localhost](http://localhost)にアクセスし、ログイン画面が表示されれば完了！

# artisanコマンド集
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

10. プロバイダーの作成
```
php artisan make:provider RiakServiceProvider
```
