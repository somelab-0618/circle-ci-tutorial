<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $response = $this->get(route('articles.index'));

        $response->assertStatus(400)->assertViewIs('articles.index');
    }

    // 未ログインのテスト
    public function testGuestCreate()
    {
        $response = $this->get(route('articles.create'));
        $response->assertRedirect(route('login'));
    }

    // ログイン時のテスト
    public function testAuthCreate()
    {
        // ※ テストは Arrange[準備] → Action[実行] → Assert[検証]を意識する
        // Userモデルのインスタンス生成しDBに保存 [準備]
        $user = factory(User::class)->create();

        // $userでログイン状態 [実行]
        $response = $this->actingAs($user)->get(route('articles.create'));

        // 記事投稿ページへアクセス [検証]
        $response->assertStatus(200)->assertViewIs('articles.create');
    }
}
