<!-- builder -->
<div id="builder">
    <!-- 페이지 관리 -->
    <div class="tool-box left-box">
        <h5 class="title-left">페이지관리</h5>
        <button class="btn btn-primary btn-add-page w-100">페이지추가</button>

        <h6 class="my-3">페이지목록</h6>
        <div class="pages"></div>
    </div>

    <!-- modals -->
    <div class="modal" id="logoModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        로고수정
                    </div>
                </div>
                <div class="modal-body">
                    <img class="current-logo mb-3" src="" alt="logo" title="logo">

                    <p>로고</p>
                    <form action="/upload" method="post" enctype="multipart/form-data">
                        <input type="text" class="custom-file-input" name="file" hidden>

                        <div class="form-group">
                            <div class="custom-file">
                                <label for="logo" class="custom-file-label">파일을
                                    선택해주세요.</label>
                                <input type="file" class="custom-file-input" id="logo" name="logo" hidden>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-3">등록</button>
                    </form>
                    <div class="logos row">
                        <?php
                        //                        $dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads';
                        //                        $handle = opendir($dir);
                        //
                        //                        while ($file = readdir($handle)) {
                        //                            if (is_file("$dir/$file")) {
                        //                                echo "<img src='/uploads/$file' class='col-4' alt='logo' title='logo'>";
                        //                            }
                        //                        }
                        ?>
                        <img src="/images/logo.png" class="col-4" alt="logo" title="logo">
                        <!--                        <img src="/images/logo/logo2.png" class="col-4" alt="logo" title="logo">-->
                        <!--                        <img src="/images/logo/logo3.png" class="col-4" alt="logo" title="logo">-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="visualImagesModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        비주얼이미지선택
                    </div>
                </div>
                <div class="modal-body">
                    <p>비주얼이미지</p>
                    <form action="/upload" method="post" enctype="multipart/form-data">
                        <input type="text" class="custom-file-input" name="file" hidden>

                        <div class="form-group">
                            <div class="custom-file">
                                <label for="visualImage" class="custom-file-label">파일을
                                    선택해주세요.</label>
                                <input type="file" id="visualImage" class="custom-file-input" name="visual" hidden>
                            </div>
                        </div>
                        <button class="btn btn-primary w-100 mb-3">등록</button>
                    </form>

                    <div class="visual-images row">
                        <img src="/images/visual/1.jpg" class="col-4 active" alt="visual" title="visual">
                        <img src="/images/visual/2.jpg" class="col-4 active" alt="visual" title="visual">
                        <img src="/images/visual/3.jpg" class="col-4 active" alt="visual" title="visual">
                        <!--                        <img src="/images/visual/2.jpg" class="col-4" alt="visual-image"-->
                        <!--                                  title="visual-image">-->
                        <!--                    <img src="/images/visual/3.jpg" class="col-4" alt="visual-image"-->
                        <!--                         title="visual-image">-->
                        <!--                    <img src="/images/visual/4.jpg" class="col-4" alt="visual-image"-->
                        <!--                         title="visual-image">-->
                        <!--                    <img src="/images/visual/5.jpg" class="col-4" alt="visual-image"-->
                        <!--                         title="visual-image">-->
                        <!--                    <img src="/images/visual/6.jpg" class="col-4" alt="visual-image"-->
                        <!--                         title="visual-image">-->
                        <!--                    <img src="/images/visual/7.jpg" class="col-4" alt="visual-image"-->
                        <!--                         title="visual-image">-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="galleryModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        갤러리 이미지 선택
                    </div>
                </div>
                <div class="modal-body">
                    <p>갤러리 이미지</p>
                    <form action="/upload" method="post" enctype="multipart/form-data">
                        <input type="text" name="file" hidden>
                        <div class="form-group">
                            <div class="custom-file">
                                <label for="galleryImage" class="custom-file-label">파일을 선택해주세요.</label>
                                <input type="file" id="galleryImage" class="custom-file-input" name="gallery" hidden>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mb-3 w-100">등록</button>
                    </form>

                    <div class="gallery-images card-columns">
                        <img src="/images/gallery/1.jpg" alt="gallery" title="gallery" class="card">
                        <img src="/images/gallery/2.jpg" alt="gallery" title="gallery" class="card">
                        <img src="/images/gallery/3.jpg" alt="gallery" title="gallery" class="card">
                        <img src="/images/gallery/4.jpg" alt="gallery" title="gallery" class="card">
                        <img src="/images/gallery/5.jpg" alt="gallery" title="gallery" class="card">
                        <img src="/images/gallery/6.png" alt="gallery" title="gallery" class="card">
                        <!--                        <img src="/images/gallery/2.jpg" alt="gallery-image"-->
                        <!--                             title="gallery-image" class="card">-->
                        <!--                        <img src="/images/gallery/3.jpg"-->
                        <!--                             alt="gallery-image"-->
                        <!--                             title="gallery-image"-->
                        <!--                             class="card"><img-->
                        <!--                                src="/images/gallery/4.jpg" alt="gallery-image"-->
                        <!--                                title="gallery-image" class="card">-->
                        <!--                        <img src="/images/gallery/5.jpg"-->
                        <!--                             alt="gallery-image"-->
                        <!--                             title="gallery-image"-->
                        <!--                             class="card"><img-->
                        <!--                                src="/images/gallery/6.png" alt="gallery-image"-->
                        <!--                                title="gallery-image" class="card">-->
                        <!--                        <img src="/images/gallery/7.png"-->
                        <!--                             alt="gallery-image"-->
                        <!--                             title="gallery-image"-->
                        <!--                             class="card"><img-->
                        <!--                                src="/images/gallery/8.jpg" alt="gallery-image"-->
                        <!--                                title="gallery-image" class="card">-->
                        <!--                        <img src="/images/gallery/9.png"-->
                        <!--                             alt="gallery-image"-->
                        <!--                             title="gallery-image"-->
                        <!--                             class="card"><img-->
                        <!--                                src="/images/gallery/10.jpg" alt="gallery-image"-->
                        <!--                                title="gallery-image" class="card">-->
                        <!--                        <img-->
                        <!--                                src="/images/gallery/11.jpg" alt="gallery-image"-->
                        <!--                                title="gallery-image" class="card">-->
                        <!--                        <img-->
                        <!--                                src="/images/gallery/12.jpg" alt="gallery-image"-->
                        <!--                                title="gallery-image" class="card">-->
                        <!--                        <img-->
                        <!--                                src="/images/gallery/13.jpg" alt="gallery-image"-->
                        <!--                                title="gallery-image" class="card">-->
                        <!--                        <img-->
                        <!--                                src="/images/gallery/14.jpg" alt="gallery-image"-->
                        <!--                                title="gallery-image" class="card">-->
                        <!--                        <img-->
                        <!--                                src="/images/gallery/15.jpg" alt="gallery-image"-->
                        <!--                                title="gallery-image" class="card">-->
                        <!--                        <img-->
                        <!--                                src="/images/gallery/16.jpg" alt="gallery-image"-->
                        <!--                                title="gallery-image" class="card">-->
                        <!--                        <img-->
                        <!--                                src="/images/gallery/17.jpg" alt="gallery-image"-->
                        <!--                                title="gallery-image" class="card">-->
                        <!--                        <img-->
                        <!--                                src="/images/gallery/18.jpg" alt="gallery-image"-->
                        <!--                                title="gallery-image" class="card">-->
                        <!--                        <img-->
                        <!--                                src="/images/gallery/19.jpg" alt="gallery-image"-->
                        <!--                                title="gallery-image" class="card">-->
                        <!--                        <img-->
                        <!--                                src="/images/gallery/20.jpg" alt="gallery-image"-->
                        <!--                                title="gallery-image" class="card">-->
                        <!--                        <img-->
                        <!--                                src="/images/gallery/21.jpg" alt="gallery-image"-->
                        <!--                                title="gallery-image" class="card">-->
                        <!--                        <img-->
                        <!--                                src="/images/gallery/22.jpg" alt="gallery-image"-->
                        <!--                                title="gallery-image" class="card">-->
                        <!--                        <img-->
                        <!--                                src="/images/gallery/23.jpg" alt="gallery-image"-->
                        <!--                                title="gallery-image" class="card">-->
                        <!--                        <img-->
                        <!--                                src="/images/gallery/24.jpg" alt="gallery-image"-->
                        <!--                                title="gallery-image" class="card">-->
                        <!--                        <img-->
                        <!--                                src="/images/gallery/25.jpg" alt="gallery-image"-->
                        <!--                                title="gallery-image" class="card">-->
                        <!--                        <img-->
                        <!--                                src="/images/gallery/26.jpg" alt="gallery-image"-->
                        <!--                                title="gallery-image" class="card">-->
                        <!--                        <img-->
                        <!--                                src="/images/gallery/27.jpg" alt="gallery-image"-->
                        <!--                                title="gallery-image" class="card">-->
                        <!--                        <img-->
                        <!--                                src="/images/gallery/28.jpg" alt="gallery-image"-->
                        <!--                                title="gallery-image" class="card">-->
                        <!--                        <img-->
                        <!--                                src="/images/gallery/29.jpg" alt="gallery-image"-->
                        <!--                                title="gallery-image" class="card">-->
                        <!--                        <img-->
                        <!--                                src="/images/gallery/30.jpg" alt="gallery-image"-->
                        <!--                                title="gallery-image" class="card">-->
                        <!--                        <img-->
                        <!--                                src="/images/gallery/31.jpg" alt="gallery-image"-->
                        <!--                                title="gallery-image" class="card">-->
                        <!--                        <img-->
                        <!--                                src="/images/gallery/32.jpg" alt="gallery-image"-->
                        <!--                                title="gallery-image" class="card">-->
                        <!--                        <img-->
                        <!--                                src="/images/gallery/33.jpg" alt="gallery-image"-->
                        <!--                                title="gallery-image" class="card">-->
                        <!--                        <img-->
                        <!--                                src="/images/gallery/34.jpg" alt="gallery-image"-->
                        <!--                                title="gallery-image" class="card">-->
                        <!--                        <img-->
                        <!--                                src="/images/gallery/35.png" alt="gallery-image"-->
                        <!--                                title="gallery-image" class="card">-->

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 페이지 제작 -->
    <div class="tool-box right-box">
        <h5 class="title-left">페이지제작</h5>

        <button class="btn btn-primary btn-add-layout w-100 mb-3">레이아웃추가</button>

        <ul class="layouts list-group d-none mb-3">
            <li class="layout list-group-item">
                <span>Visual</span>
                <ul class="list-group">
                    <li class="list-group-item">Visual_1</li>
                    <li class="list-group-item">Visual_2</li>
                </ul>
            </li>
            <li class="layout list-group-item">
                <span>Features</span>
                <ul class="list-group">
                    <li class="list-group-item">Features_1</li>
                    <li class="list-group-item">Features_2</li>
                </ul>
            </li>
            <li class="layout list-group-item">
                <span>Gallery&Slider</span>
                <ul class="list-group">
                    <li class="list-group-item">Gallery&Slider_1</li>
                    <li class="list-group-item">Gallery&Slider_2</li>
                </ul>
            </li>
            <li class="layout list-group-item">
                <span>Contacts</span>
                <ul class="list-group">
                    <li class="list-group-item">Contacts_1</li>
                    <li class="list-group-item">Contacts_2</li>
                </ul>
            </li>
        </ul>

        <button class="btn btn-primary btn-option w-100 mb-3">설정</button>

        <!-- 옵션들 -->
        <div class="options">
            <div class="option option-header">
                <button class="btn btn-primary btn-open-logo-modal w-100 mb-3">로고수정</button>

                <h6 class="my-3">메뉴목록</h6>

                <ul class="menus list-unstyled"></ul>

                <button class="btn btn-primary btn-add-menu mr-3">메뉴추가하기</button>
                <button class="btn btn-danger btn-remove-menu">메뉴삭제하기</button>
            </div>
            <div class="option option-visual">

                <button class="btn btn-primary w-100 btn-edit-visual-images">비주얼이미지수정</button>

                <h6 class="my-3">보이기/감추기</h6>
                <div class="show-or-hide">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" id="showTitle" class="custom-control-input">
                        <label for="showTitle" class="custom-control-label">타이틀</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" id="showDesc" class="custom-control-input">
                        <label for="showDesc" class="custom-control-label">요약설명</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" id="showLink" class="custom-control-input">
                        <label for="showLink" class="custom-control-label">바로가기링크</label>
                    </div>
                </div>

            </div>

            <div class="option option-features">
                <div class="form-group">
                    <label for="featuresTitle">문단타이틀</label>
                    <input type="text" placeholder="문단타이틀" id="featuresTitle" name="sectionTitle" class="form-control">
                </div>

                <h6 class="my-3">보이기/감추기</h6>
                <div class="show-or-hide">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" id="showFTitle" class="custom-control-input">
                        <label for="showFTitle" class="custom-control-label">타이틀</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" id="showFIcon" class="custom-control-input">
                        <label for="showFIcon" class="custom-control-label">아이콘</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" id="showFText" class="custom-control-input">
                        <label for="showFText" class="custom-control-label">텍스트</label>
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" id="showFLink" class="custom-control-input">
                        <label for="showFLink" class="custom-control-label">링크버튼</label>
                    </div>
                </div>
            </div>

            <div class="option option-gallery">
                <div class="form-group">
                    <label for="galleryTitle">문단타이틀</label>
                    <input type="text" name="sectionTitle" id="galleryTitle" class="form-control">
                </div>

                <h3>보이기/감추기</h3>
                <div class="show-or-hide">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" id="showGTitle" class="custom-control-input">
                        <label for="showGTitle" class="custom-control-label">타이틀</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" id="showGSubTitle" class="custom-control-input">
                        <label for="showGSubTitle" class="custom-control-label">서브타이틀</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" id="showGText" class="custom-control-input">
                        <label for="showGText" class="custom-control-label">텍스트</label>
                    </div>
                </div>
            </div>

            <div class="option option-contacts">
                <div class="form-group">
                    <label for="contactsTitle">문단타이틀</label>
                    <input type="text" name="sectionTitle" id="contactsTitle" class="form-control">
                </div>

                <h3>보이기/감추기</h3>
                <div class="show-or-hide">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" id="showCAddress" class="custom-control-input">
                        <label for="showCAddress" class="custom-control-label">주소</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" id="showCPhone" class="custom-control-input">
                        <label for="showCPhone" class="custom-control-label">전화번호</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" id="showCEmail" class="custom-control-input">
                        <label for="showCEmail" class="custom-control-label">이메일</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="formColor" class="sr-only">배경색 변경</label>
                    <input type="color" class="form-control-sm" id="formColor" name="formColor" hidden>
                    <button class="btn btn-primary btn-change-bg w-100 mt-3">배경색 변경</button>
                </div>
            </div>

            <div class="option option-footer">
                <div class="form-group">
                    <label for="bgColor" class="sr-only">배경색 변경</label>
                    <input type="color" class="form-control-sm" id="bgColor" name="bgColor" hidden>
                    <button class="btn btn-primary btn-edit-bg w-100">배경색수정</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 앱 -->
<div id="app" class="teaser-builder">
    <div class="modal" id="galleryImageModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">갤러리 이미지 보기</h5>
                </div>
                <div class="modal-body">
                    <img src="" class="img-fluid" alt="gallery" title="gallery">
                </div>
            </div>
        </div>
    </div>
</div>