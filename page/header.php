<header>
    <nav class="navbar navbar-expand bg-dark text-light">
        <div class="container">
            <ul class="ml-auto navbar-nav">
                <li class="nav-item d-flex align-items-center">
                    <?php
                    if ($params[0] == 'teaser_builder') { ?>
                        <button class="btn btn-primary btn-save-page btn-sm">페이지 적용하기</button>
                    <?php } ?>
                </li>
                <li class="nav-item">
                    <a href="/statistics" class="nav-link">접속통계</a>
                </li>

<!--                <li class="nav-item">-->
<!--                    <a href="/invite" class="nav-link">온라인초대장관리</a>-->
<!--                </li>-->
            </ul>
    </nav>
</header>