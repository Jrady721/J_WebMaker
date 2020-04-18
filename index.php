<?php require_once 'lib/lib.php'; ?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>Blocre</title>

    <!-- styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel="stylesheet" href="/css/style.css">

    <!-- scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/js/bootstrap.min.js"></script>
    <script src="/js/apps.js" defer></script>
</head>
<body>

<?php
if ($params[0] == 'teaser_builder') {
    include_once "page/$params[0].php";
    include "page/header.php";
} else {
    /* 만약 페이지 인자값으로 넘겨온 것이 파일이 아니라면... */
    if (!is_file("page/$params[0].php")) {
        /* 티저 페이지 코드가 입력되었다. */
        $page = $pdo->query("select * from pages where code = '$params[0]'")->fetch();

        /* 페이지가 있으면 페이지 불러오기 */
        if ($page) {
            /* upload 는 나중에 파일 업로드할 때 mkdir로 추가할 예정 */
            echo $page->html;

            // print_r($_SERVER)
            // echo "<h1>".$_SERVER['HTTP_USER_AGENT']."</h1>";
            $agent = $_SERVER['HTTP_USER_AGENT'];

            $browser = '기타';

            if (preg_match('/Chrome/i', $agent)) $browser = '크롬';
            if (preg_match('/Trident/i', $agent)) $browser = '인터넷 익스플로러';
            if (preg_match('/Firefox/i', $agent)) $browser = '파이어 폭스';
            if (preg_match('/Edge/i', $agent)) $browser = '엣지';
            // 엣지는 Chrome이란 단어도 있기 때문에 마지막에 찾아야함

            /* 방문할 때마다 추가하준다. */
            $pdo->query("insert into visits (browser, date) values('$browser', now())");
        } else {
            alert('잘못된 티저페이지 코드이다.');
        }
    } else {
        /* 페이지 불러오기 */
        include_once "page/$params[0].php";
    }
} ?>
</body>
</html>