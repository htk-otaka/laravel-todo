<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Requests\CreateTask;
use Carbon\Carbon;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 各テストメソッドの実行前に呼ばれるメソッド
     * 用途：タスクのテストに必要な FoldersTableSeeder を実行する
     *
     */
    public function setUp():void
    {
        parent::setUp();

        $this->seed('FoldersTableSeeder');
    }

    /**
     * @test
     */
    public function due_date_should_be_date()
    {
        $response = $this->post('/folders/1/tasks/create', [
            'title' => 'Sample Task',
            'due_date' => 123,
        ]);

        $response->assertSessionHasErrors([
            'due_date' => '期限日 には今日以降の日付を入力してください。',
        ]);
    }

    /**
     * @test
     */
    public function due_date_should_not_be_past()
    {
        $response = $this->post('/folders/1/tasks/create', [
            'title' => 'Sample task',
            'due_date' => Carbon::yesterday()->format('Y/m/d'),
        ]);

        $response->assertSessionHasErrors([
            'due_date' => '期限日 には今日以降の日付を入力してください。',
        ]);
    }

    /**
     * @test
     */
    public function status_should_be_within_defined_numbers()
    {
        $this->seed('TasksTableSeeder');

        $response = $this->post('/folders/1/tasks/1/edit', [
            'title' => 'Sample Task',
            'due_date' => Carbon::today()->format('Y/m/d'),
            'status' => 999,
        ]);

        $response->assertSessionHasErrors([
            'status' => '状態 には 未着手、着手中、完了のいずれかを指定してください。',
        ]);
    }
}
