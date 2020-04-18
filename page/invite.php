<?php
include "header.php";
?>
<div id="invite">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="box">
                    <h2 class="my-5">온라인 초대장 등록</h2>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <p>행사명</p>
                            <input type="text" name="name" class="form-control" placeholder="행사명">
                        </div>
                        <div class="form-group">
                            <p>고유코드</p>
                            <input type="text" name="code" class="form-control" placeholder="고유코드">
                        </div>
                        <div class="form-group">
                            <p>초청대상자 파일</p>
                            <div class="custom-file">
                                <label for="file" class="custom-file-label">파일을 선택해주세요.</label>
                                <input type="file" id="file" name="file" class="custom-file-input">
                            </div>
                        </div>
                        <div class="mt-2 d-flex justify-content-end">
                            <button class="btn btn-primary w-100">등록</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
