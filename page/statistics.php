<?php

$graph = null;

if (isset($params[1])) {

    $start = $params[1];
    $end = $params[2];

    if (empty($start) || empty($end)) {
        alert('모든 항목에 입력해주세요.');
        back();
    }

    if ($start > $end) {
        alert('잘못된 기간 입니다.');
        back();
    }

    $graph = [
        "/graph/bar/$start/$end",
        "/graph/pie/$start/$end"
    ];

    $data = $pdo->query("select browser, count(idx) as cnt from visits where '$start' <= date AND date <= '$end' group by browser order by cnt desc")->fetchAll();

    if (!$data) {
        alert('해당 기간에는 접속 기록이 없습니다.');
        back();
    }
}


include 'header.php';

?>
<section id="statistics">
    <div class="container">
        <div class="row">
            <div class="col-3">
                <div class="box">
                    <form action="" method="get">
                        <div class="form-inline">
                            <label for="start" class="col-4">시작일</label>
                            <input type="date" name="start" class="form-control col-8" value="<?= $start ?>">
                        </div>
                        <div class="mt-2 form-inline">
                            <label for="end" class="col-4">
                                종료일
                            </label>
                            <input type="date" id="end" name="end" class="form-control col-8" value="<?= $end ?>">
                        </div>
                        <div class="mt-2 d-flex justify-content-end">
                            <button class="btn btn-primary w-100">조회</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-9">
                <div class="box">
                    <h3 class="mb-3">접속통계</h3>
                    <?php if ($graph) { ?>
                        <div class="mt-5 mb-3">
                            <?= $start ?> ~ <?= $end ?>
                        </div>

                        <div class="d-flex justify-content-between mt-5 mb-5">
                            <div class="img">
                                <img src="<?= $graph[0] ?>" alt="graph" title="graph">
                            </div>
                            <div class="img">
                                <img src="<?= $graph[1] ?>" alt="graph" title="graph">
                            </div>
                        </div>

                        <img src="/graph/text/<?= $start ?>/<?= $end ?>" alt="text" title="text">
                        <?php
//                        $total = 0;
//                        function box($name)
//                        {
//                            if ($name == '크롬')
//                                return '<span style="display:inline-block; width:15px; height:15px; margin-right:.5rem; background:#dc4c40"></span>';
//                            if ($name == '인터넷 익스플로러')
//                                return '<span style="display:inline-block; width:15px; height:15px; margin-right:.5rem; background:#8edbe3"></span>';
//                            if ($name == '파이어 폭스')
//                                return '<span style="display:inline-block; width:15px; height:15px; margin-right:.5rem; background:#ffac00"></span>';
//                            if ($name == '엣지')
//                                return '<span style="display:inline-block; width:15px; height:15px; margin-right:.5rem; background:#0078d7"></span>';
//                            if ($name == '기타')
//                                return '<span style="display:inline-block; width:15px; height:15px; margin-right:.5rem; background:#333"></span>';
//                        }



                        ?>

                    <?php } else { ?>
                        <p>날짜를 선택해주세요</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>