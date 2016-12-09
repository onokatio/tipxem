<?php
	require 'vendor/autoload.php'; //composerの自動ロード
	require 'key.php'; //TwitterAPIのdefine読み込み

	use mpyw\Co\Co; //名前空間を干渉しないようにするための設定
	use mpyw\Co\CURLException;
	use mpyw\Cowitter\Client;
	use mpyw\Cowitter\HttpException;

	try {
		Co::wait(function () {
			$client = new Client([CK, CS, AT, ATS]); //API情報からクライアントオブジェクトを作成	
			//$client->post('statuses/update', ['status' => 'test tweet by api']);
			$task = $client->streamingAsync('user', function ($status) {
				if (!isset($status->text)) return;
				echo "===================={$status->user->name}({$status->user->screen_name})====================\n{$status->text}\n";
			});
			yield $task;
		});
	} catch (RuntimeException $e) { //エラーが起こった時の情報を変数$eに入れる
		exit("Error: {$e->getMessage()}\n"); //エラーが起きたらメッセージを表示して終了
	}
?>
