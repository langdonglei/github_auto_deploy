<?php
# github自动部署
Route::post('/deploy',function(){
    $s1=$_SERVER['HTTP_X_HUB_SIGNATURE'];
    $s2='sha1='.hash_hmac('sha1',file_get_contents('php://input'),$_ENV['GITHUB_WEBHOOK_SECRET']);
    if($s1==$s2){
        $path = base_path();
        $proc = proc_open("cd $path && git pull", [1=>['pipe','w'],2=>['pipe','w']], $pipes);
        echo stream_get_contents($pipes[1]);
        echo stream_get_contents($pipes[2]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        proc_close($proc);
    }
});