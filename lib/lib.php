<?php

/* DB 설정 */
$pdo = new pdo('mysql:host=localhost; dbname=chungnam', 'root', '', array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'set names utf8'
));

/* 세션 만료 시간 설정 (2시간) */
session_cache_expire(120);

/* 세션 시작 */
session_start();

date_default_timezone_set('Asia/Seoul');


/* 함수들 */
function alert($msg)
{
    echo "<script>alert('$msg')</script>";
}

function move($url)
{
    echo "<script>location.replace('$url')</script>";
}

function back()
{
    echo "<script>history.back()</script>";
    exit();
}


function color($img, $name)
{
    if ($name == '인터넷 익스플로러') return imagecolorallocate($img, 0x8e, 0xdb, 0xe3);
    if ($name == '파이어 폭스') return imagecolorallocate($img, 0xff, 0xac, 0x00);
    if ($name == '크롬') return imagecolorallocate($img, 0xdc, 0x4c, 0x40);
    if ($name == '엣지') return imagecolorallocate($img, 0x00, 0x78, 0xd7);
    return imagecolorallocate($img, 0x33, 0x33, 0x33);
}


if (!is_dir('./uploads')) {
    mkdir('./uploads');
}

define('ROOT', $_SERVER["DOCUMENT_ROOT"]);

/* 리퀘스트 풀어주기 */
extract($_REQUEST);
$uri = $_SERVER["REQUEST_URI"];

//echo $uri."<br>";

$params = explode('/', $_SERVER["REQUEST_URI"]);

array_shift($params);

if (!$params[0]) $params[0] = 'index';
//var_dump($params);

if ($_GET) {
    $cleanURL = explode('?', $uri)[0];

    foreach ($_GET as $key => $value) {
        unset($_GET[$key]);
        $cleanURL .= '/' . $value;
    }
    move($cleanURL);
}

$method = $_SERVER["REQUEST_METHOD"];
if ($method == 'GET') {
    /* 페이지가 index 일 경우 */
    if ($params[0] == 'index') {
        move('/admin');
    } else if ($params[0] == 'graph') {
        // 크롬 #dc4c40
        // 인터넷 익스플로러 #8edbe3
        // 파이어 폭스 #ffac00
        // 엣지 #0078d7
        // 기타 #333
        $type = $params[1];
        $start = $params[2];
        $end = $params[3];
        $padding = 20;

        /* idx 갯수를 카운트 한다.. */
        $data = $pdo->query("SELECT browser, COUNT(idx) as cnt FROM visits WHERE '$start' <= date AND date <= '$end' group by browser order by cnt desc")->fetchAll();

        if ($type == 'text') {
            $font = "C:\Windows\Fonts\Malgun.ttf";
            $img = imagecreatetruecolor(800, 150);
            imagefill($img, 0, 0, imagecolorallocate($img, 250, 250, 250));

            /* 라인 그리기 */
            $lineColor = imagecolorallocate($img, 200, 200, 200);

            imagefilledrectangle($img, 0, 0, 800, 0.1, $lineColor);
            imagefilledrectangle($img, 0, 50, 800, 50.1, $lineColor);
            imagefilledrectangle($img, 0, 100, 800, 100.1, $lineColor);


            /* th 그리기 */
            $text = "유형별";
            imagettftext($img, 12, 0, 20, 32, imagecolorallocate($img, 0, 0, 0), $font, $text);
            $text = "접속자수";
            imagettftext($img, 12, 0, 20, 82, imagecolorallocate($img, 0, 0, 0), $font, $text);
            $text = "비율";
            imagettftext($img, 12, 0, 20, 132, imagecolorallocate($img, 0, 0, 0), $font, $text);


            /* td 그리기 */
            $data = $pdo->query("select browser, count(idx) as cnt from visits where '$start' <= date AND date <= '$end' group by browser order by cnt desc")->fetchAll();

            $x = 160;

            $total = 0;
            foreach ($data as $item) {
                /* 값 추가 */
                $total += $item->cnt;
            }

            foreach ($data as $item) {
                $text = $item->browser;
                imagettftext($img, 12, 0, $x, 32, color($img, $item->browser), $font, $text);

                $text = $item->cnt;
                imagettftext($img, 12, 0, $x, 82, color($img, $item->browser), $font, $text);

                $text = round($item->cnt / $total * 100 * 10) / 10 . '%';

                imagettftext($img, 12, 0, $x, 132, color($img, $item->browser), $font, $text);

                $x += 800 * (1 / 5);
            }
        } else {

            $img = imagecreatetruecolor(800, 800);
            $bg = imagecolorallocate($img, 250, 250, 250);

            imagefilledrectangle($img, 0, 0, 800, 800, $bg);

            if ($type == 'bar') {
                /* 총 데이터 길이 */
                $len = count($data);
                $cnt = ($len * 2 + 1);
                $one = 800 / $cnt;
                $max = $data[0]->cnt;
                $idx = 0;

                foreach ($data as $item) {
                    $h = 800 - ($padding * 2);
                    $x1 = ($idx * 2 + 1) * $one;

                    $y1 = $h - ($item->cnt / $max * $h) + $padding;
                    $x2 = $x1 + $one;
                    $y2 = $h + $padding;
                    $idx++;
                    imagefilledrectangle($img, $x1, $y1, $x2, $y2, color($img, $item->browser));
                }
            } else if ($type == 'pie') {
                $total = 0;

                $sum = 0;

                foreach ($data as $item) $total += $item->cnt;

                foreach ($data as $item) {

                    $start = $sum / $total * 360;

                    $end = ($item->cnt + $sum) / $total * 360;

                    imagefilledarc($img, 400, 400, 700, 700, $start, $end, color($img, $item->browser), IMG_ARC_PIE);

                    $sum += $item->cnt;
                }
            }
        }
        header('content-type:image/png');
        imagepng($img);
        imagedestroy($img);
        exit();
    } else if ($params[0] == 'download') {
        $data = $pdo->query("select * from excel")->fetchAll();

        // shared
        $shared = '
			<sst xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" count="31" uniqueCount="31">
			<si>
			<t>초청일련번호</t>
			<phoneticPr fontId="1" type="noConversion"/>
			</si>
			<si>
			<t>초청자명</t>
			<phoneticPr fontId="1" type="noConversion"/>
			</si>
			<si>
			<t>이메일주소</t>
			<phoneticPr fontId="1" type="noConversion"/>
			</si>
		';
        foreach ($data as $item) {
            $shared .= "
				<si>
				<t>{$item->name}</t>
				</si>
				<si>
				<t>{$item->email}</t>
				</si>
			";
        }
        $shared .= '</sst>';

        $sheet = '
			<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:mc="http://schemas.openxmlformats.org/markup-compatibility/2006" xmlns:x14ac="http://schemas.microsoft.com/office/spreadsheetml/2009/9/ac" mc:Ignorable="x14ac">
			<dimension ref="A1:C15"/>
			<sheetViews>
			<sheetView tabSelected="1" zoomScaleNormal="100" workbookViewId="0">
			<selection activeCell="A2" sqref="A2:A15"/>
			</sheetView>
			</sheetViews>
			<sheetFormatPr defaultRowHeight="16.5" x14ac:dyDescent="0.3"/>
			<cols>
			<col min="1" max="1" width="13" bestFit="1" customWidth="1"/>
			<col min="3" max="3" width="19.5" bestFit="1" customWidth="1"/>
			</cols>
			<sheetData>
			<row r="1" spans="1:3" x14ac:dyDescent="0.3">
			<c r="A1" t="s">
			<v>0</v>
			</c>
			<c r="B1" t="s">
			<v>1</v>
			</c>
			<c r="C1" t="s">
			<v>2</v>
			</c>
			</row>
		';
        $i = 1;
        $n = 2;
        foreach ($data as $item) {
            ++$i;
            $sheet .= '
				<row r="' . $i . '" spans="1:3" x14ac:dyDescent="0.3">
				<c r="A' . $i . '">
				<v>' . $item->num . '</v>
				</c>
				<c r="B' . $i . '" t="s">
				<v>' . ++$n . '</v>
				</c>
				<c r="C' . $i . '" s="1" t="s">
				<v>' . ++$n . '</v>
				</c>
				</row>
			';
        }
        $sheet .= '
			</sheetData>
			<phoneticPr fontId="1" type="noConversion"/>
			<pageMargins left="0.7" right="0.7" top="0.75" bottom="0.75" header="0.3" footer="0.3"/>
			<pageSetup paperSize="9" orientation="portrait" r:id="rId1"/>
			</worksheet>
		';

        // 덮어쓰기
        $handle = fopen(ROOT . '/data/xl/sharedStrings.xml', 'w');
        fwrite($handle, $shared);
        fclose($handle);

        $handle = fopen(ROOT . '/data/xl/worksheets/sheet1.xml', 'w');
        fwrite($handle, $sheet);
        fclose($handle);

        function addFolderToZip($dir, $zipArchive, $zipdir = '')
        {
            if (is_dir($dir)) {
                if ($dh = opendir($dir)) {

                    //Add the directory
                    if (!empty($zipdir)) $zipArchive->addEmptyDir($zipdir);

                    // Loop through all the files
                    while (($file = readdir($dh)) !== false) {

                        //If it's a folder, run the function again!
                        if (!is_file($dir . $file)) {
                            // Skip parent and root directories
                            if (($file !== ".") && ($file !== "..")) {
                                addFolderToZip($dir . $file . "/", $zipArchive, $zipdir . $file . "/");
                            }

                        } else {
                            // Add the files
                            $zipArchive->addFile($dir . $file, $zipdir . $file);

                        }
                    }
                }
            }
        }

        // 압축파일 만들기 - zeal(ZipArchive::addEmptyDir에서 4번째 예제)
        // $zipname = md5(microtime()) . '.xlsx';
//        $zipname = '초청자정보_' . uniqid() . '.xlsx';
        $zipname = '초청대상자.xlsx';
        $zip = new \ZipArchive;
        $zip->open(ROOT . '/excel/' . $zipname, \ZipArchive::CREATE);
        addFolderToZip(ROOT . '/data/', $zip);

        $zip->close();

        // 다운로드 - zeal(ZipArchive의 download라고 검색)
        // $length = filesize(ROOT.'/public/excel/'.$name);
        // header('Content-Type: application/zip');
        // header('Content-disposition: attachment; filename='.$name);
        // header('Content-Length: ' . $length);
        // readfile(ROOT.'/public/excel/'.$name);
        header('Content-Type: application/zip');
        header('Content-disposition: attachment; filename=' . $zipname);
        header('Content-Length: ' . filesize(ROOT . '/excel/' . $zipname));
        readfile(ROOT . '/excel/' . $zipname);
    }
} else if ($method == 'POST') {
    $error = '';

    if ($params[0] == 'admin') {
        if ($id == '') {
            $error .= '아이디를 입력해주세요.\n';
        }

        if ($password == '') {
            $error .= '패스워드를 입력해주세요.\n';
        }

        $password = hash('sha256', $password);

        $user = $pdo->query("select * from users where id = '$id' and password = '$password'")->fetch();

        if (!$user) {
            $error .= '아이디와 패스워드가 일치하지 않습니다.\n';
        }
        if (!$error) {
            alert('로그인 성공');
            $page = $pdo->query("select * from pages")->fetch();

            if ($page) {
                /* 마지막 생성된 페이지로 이동한다. */
                move("/$page->code");
            } else {
                /* 없으면 관리페이지로.. */
                move('/teaser_builder');
            }
        }
    } else if ($params[0] == 'register') {
        if ($name == '') {
            $error .= '성명을 입력해주세요.\n';
        }

        if ($id == '') {
            $error .= '아이디를 입력해주세요.\n';
        } else if (!mb_ereg_match('^[a-zA-Z]+$', $id)) {
            $error .= '아이디는 영문만 입력 가능합니다.\n';
        }

        if ($password == '') {
            $error .= '패스워드를 입력해주세요.\n';
        } else if (!mb_ereg_match('^[a-zA-Z0-9]+$', $password) || mb_ereg_match('^[a-zA-Z]+$', $password) || mb_ereg_match('^[0-9]+$', $password)) {
            $error .= '패스워드는 영문, 숫자 조합만 입력 가능합니다.\n';
        }

        if ($email == '') {
            $error .= '이메일을 입력해주세요.\n';
        }

        if (!$error) {
            alert('회원가입 성공');
            $password = hash('sha256', $password);
            $pdo->query("insert into users(name, id, password, email) values('$name', '$id', '$password', '$email')");

            move('/admin');
        }
    } else if ($params[0] == 'upload') {
        if ($file == '') {
            $error .= '파일을 선택해주세요.\n';
        } else {
            $data = $file;
            list($type, $data) = explode(';', $data);
            list(, $data) = explode(',', $data);
            $data = base64_decode($data);

            /* 파일 크기 */
            $size = strlen($data);

            /* 타입 */
            $type = explode('/', $type)[1];

            if ($type != 'jpeg' && $type != 'png') {
                $error .= '이미지 파일은 jpg, png만 가능합니다.\n';
            }

            if ($size > 2 * 1024 * 1024) {
                $error .= '이미지 파일은 2MB 이내만 가능합니다.\n';
            }

            if (!$error) {
                if (isset($_FILES['logo'])) {
                    $folder = 'logo';
                } else if (isset($_FILES['visual'])) {
                    $folder = 'visual';
                } else {
                    $folder = 'gallery';
                }
//                $folder = isset($_FILES['logo']) ? 'logo' : (isset($_FILES['visualImage']) ? 'visual' : 'gallery');
//                    $name = $folder; // time() 도 쓸만..

                $dir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/$folder";

                if (!is_dir($dir)) {
                    mkdir($dir);
                }

                // . 과 .. 도 계산되어서.. -2.
                $name = $folder . (count(scandir($dir)) - 1);

//                $path = "$dir/$name.$type";
                /* 무조건 png 로 저장하기.. */
                $path = "$dir/$name.png";

                /* 저장 */
                file_put_contents($path, $data);

                if ($folder == 'logo') {
                    /* 이미지 사이즈에 대한 정보 */
                    $info = getimagesizefromstring($data);
                    $w = $info[0];
                    $h = $info[1];

                    if ($w > 250 || $h > 250) {
                        if ($w > $h) {
                            $ratio = 250 / $w;
                        } else {
                            $ratio = 250 / $h;
                        }

                        $newW = $w * $ratio;
                        $newH = $h * $ratio;

                        $newImage = imagecreatetruecolor($newW, $newH);
                        imagealphablending($newImage, false);
                        imagesavealpha($newImage, true);

//                    if($type == 'jpeg') {
//                        $img = imagecreatefromjpeg($path);
//                    } else {
                        $img = imagecreatefrompng($path);
//                    }
                        imagecopyresampled($newImage, $img, 0, 0, 0, 0, $newW, $newH, $w, $h);

//                    if ($type == 'jpeg') {
//                        imagejpeg($newImage, $path);
//                    } else {
                        imagepng($newImage, $path, 9);
//                    }
                    }
                }

                /* 사이즈 1MB 이상일떄.. */
                if ($size > 1024 * 1024) {
                    if ($type == 'jpeg') {
                        $img = imagecreatefromjpeg($path);
                        imagejpeg($img, $path, 70);
                    } else {
//                        $quality = 70 * 9 / 100;
                        $img = imagecreatefrompng($path);
                        imagepng($img, $path, 7);
                    }
                }
                alert('업로드 완료!');
                exit();
            }
        }
    } else if ($params[0] == 'add.page') {
        $page = $pdo->query("select * from pages where code = '$code'")->fetch();
        $html = str_replace("'", "\\\"", $html);

        echo $code;

        if ($page) {
            $pdo->query("update pages set html = '$html' where code = '$code'");
        } else {
            $pdo->query("insert into pages (code, html) values('$code', '$html')");

        }

        echo '적용이 완료되었습니다.';
        exit();
    } else if ($params[0] == 'invite') {
//        echo '2';
//        var_dump($_REQUEST);
//        var_dump($_FILES);

        extract($_FILES);

        if (empty($name) || empty($code) || $file['error'] == 4) {
            alert('모든 항목에 입력해주세요');
            back();
        }

        $dir = $_SERVER['DOCUMENT_ROOT'] . '/data/';


        if (!is_dir($dir)) {
            mkdir($dir);
        }

        $zip = new \ZipArchive();
        $zip->open($file['tmp_name']);
        $zip->extractTo($dir);

        $sheet = simplexml_load_file($dir . '/xl/worksheets/sheet1.xml');
        $strings = simplexml_load_file($dir . '/xl/sharedStrings.xml');
        $data = [];

        $i = 0;
        foreach ($sheet->sheetData->row as $row) {
            if ($i > 0) $data[] = [$row->c->v];
            $i++;
        }

        $i = 0;
        $idx = 0;
        foreach ($strings as $string) {
            if ($i > 2) {
                if ($i % 2 == 1) {
                    $data[$idx][] = $string->t;
                } else {
                    $data[$idx][] = $string->t;
                    $idx++;
                }
            }
            $i++;
        }

//        var_dump($data);

        $pdo->query('truncate excel');
        foreach ($data as $item) {
            $pdo->query("insert into excel (num, name, email) VALUES ('$item[0]','$item[1]','$item[2]')");
        }

        alert('등록 되었습니다.');
        move('/invites');
    } else if ($params[0] == 'invites') {
        $pdo->query("INSERT INTO excel (num, name, email) VALUES ('$num','$name','$email')");
        alert('등록됨');
        move('/invites');
    }

    if ($error) alert($error);

    back();
}