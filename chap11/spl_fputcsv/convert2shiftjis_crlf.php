<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ShiftJIS, CRLFファイルに変換する</title>
</head>
<body>
    <div>
    <?php
        $filename = "mydata.csv";
        $filename_win = "mydata_win.csv";

        try{
            $fileObj = new SplFileObject($filename, "rb");
            $fileObj_win = new SplFileObject($filename_win, "wb");
        }catch(Exception $e){
            echo '<span class="error">エラーがありました。</span><br>';
            echo $e->getMessage();
            exit();
        }

        $readdata = $fileObj->fread($fileObj->getSize());
        $fileObj = null;
        $outdata = str_replace("\n", "\r\n", $readdata);
        $outdata = mb_convert_encoding($outdata, "SJIS", "auto");

        $outdata = str_replace(",", '","', $outdata);
        $outdata = str_replace("\r\n", "\"\r\n\"", $outdata);
        $outdata = '"'.$outdata;
        $outdata = mb_substr($outdata, 0, -1, "SJIS");

        $written = $fileObj_win->fwrite($outdata);
        if ($written===FALSE){
            echo '<span class="error">', "{$filename_win}に保存できませんでした。";
        } else {
            echo "{$filename}をShift-JIS, CRLFに変換した{$filename_win}を書き出しました。";
        }
    ?>
    </div>
</body>
</html>