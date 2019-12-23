<!-- 로그인 페이지 -->
<section id="admin" class="full-screen bg-light">
    <div class="container">
        <div class="login-box shadow bg-white px-4 py-5 layout-center">
            <div class="form__header text-center">
                <h2 class="title-center">C M S</h2>
                <p>관리자 페이지입니다.</p>
            </div>

            <!-- 로그인 폼 -->
            <div class="form__section pt-5">
                <form action="" method="post">
                    <div class="form-group mb-2">
<!--                        <label for="id">아이디</label>-->
                        <input type="text" name="id" id="id" class="form-control" placeholder="아이디">
                    </div>
                    <div class="form-group">
<!--                        <label for="password">패스워드</label>-->
                        <input type="password" name="password" id="password" class="form-control"
                               placeholder="비밀번호">
                    </div>

                    <button class="btn btn-primary w-100 mb-2">로그인</button>
                </form>
                <a href="/register" class="btn btn-primary w-100">회원 가입</a>
            </div>
        </div>
    </div>
</section>