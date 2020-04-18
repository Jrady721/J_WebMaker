let carouselInterval = null

/* 앱 실행 */
$(function () {
    let page = location.pathname.split('/').pop()

    /* 페이지가 빌더 페이지일 경우.. */
    if (page === 'teaser_builder') {

        if (localStorage.html) {
            $(window).scrollTop(localStorage.scroll);

            let header = $('body > header').html()
            $('body').html(localStorage.html)
            $('body > header').html(header)

            $(document).find('.tool-box.left-box').scrollTop(localStorage.left);
            $(document).find('.tool-box.right-box').scrollTop(localStorage.right);

            $(document).find('.modal:eq(0) .modal-body').scrollTop(localStorage.modal0);
            $(document).find('.modal:eq(1) .modal-body').scrollTop(localStorage.modal1);
            $(document).find('.modal:eq(2) .modal-body').scrollTop(localStorage.modal2);

            /* 포커스 된거 구하기 .. */
            let el = $(`*:eq(${localStorage.focus})`)
            el.focus()

            /* 요소 선택 selection 불러오기 (이건 정말 더러운 코드..) */
            // let sel = window.getSelection()
            // if (sel.rangeCount > 0) {
            //     // let offset = Number(localStorage.offset)
            //     // let length = Number(localStorage.sel.length)
            //     // console.log(el[0])
            //
            //     // let range = new Range()
            //     // range.setStart(sel.focusNode, offset)
            //     // range.setEnd(sel.focusNode, offset + length)
            //     //
            //     // sel.removeAllRanges()
            //     // sel.addR ange(range)
            // }
        }
        /* 왜인지는 모르겠으나 carousel 함수(부트스트랩 제공...)로 실행하면 이상하게 작동되서 내가 알아서 interval 을 만들어 주었다. */

        /* 비주얼 영역 가져와서 MODAL 부분의 이미지 active 시키기 */
        $(`.visual-images img`).removeClass('active')
        $('.carousel-item').filter(function (i, e) {
            let image = $(e).css('backgroundImage')
            image = image.split('/localhost')[1].slice(0, -2)
            $(`.visual-images img[src="${image}"]`).addClass('active')
        })

        /* 새로고침 해도 (수정창이 남아있게 만들게 위해서다.. ) */
        let target = $('.option-box').attr('data-target')
        target = $('.option-box').parent().find(target)
        // target.focus()
        $this = target
        $this.unbind()
        /* 포커스를 잃었을 때.. (블러) blur는 버블링을 방지한다... */
        $this.on('blur', function () {
            /* 클릭할 시 */
            $(document).unbind('.close-option')

            /* 옵션을 닫을 때 저장도 같이 해준다..! */
            $(document).on('click.close-option', '*', function (e) {
                /* 버블링 방지 */
                e.stopPropagation()

                // 클릭한것이 option-box 의 내용 아니면..
                if (!$(this).parents('.option-box').length) {
                    $('.option-box').remove()

                    $this.attr('contenteditable', false)
                    $(document).unbind('.close-option')
                    $this.unbind()
                }
            })
        })

        /* 화면.. */
        $('.modal form').next().find('>*:not(:first-child)').removeClass('d-none')

        initEvents()
    }

    /* 기본 적인것.. */
    clearInterval(carouselInterval)
    carouselInterval = setInterval(function () {
        /* 처음 사이트에 들어올때.. 슬라이디를 실행 해준다. */
        $(document).find('.carousel').carousel('next')
    }, 3000)

    /* 링크버튼... */
    $(document).on('click', '[data-href]', function () {
        location.href = $(this).attr('data-href')
    })
    /* 이벤트 버블링 막기 및 modal 닫기 */
    $(document).on('click', '.modal-dialog', function (e) {
        e.stopPropagation()
    })
    $(document).on('click', '.modal', function () {
        $(this).hide()
    })
    /* 갤러리 */
    $(document).on('click', '.card img', function (e) {
        e.stopPropagation()

        $('#galleryImageModal .modal-body img').attr('src', $(this).attr('src'))
        $('#galleryImageModal').show()
    })
    /* */
    $(document).on('change', '[type=file]', function () {
        if ($(this).val()) {
            $(this).prev().text($(this).val().split('\\').pop())
        } else {
            $(this).prev().text('파일을 선택해주세요.');
            $(this).parents('form').find('[name=file]').val('').attr('value', '')
        }
    })
})

/* 이벤트 초기화 */
function initEvents() {
    /* 저장 */
    $(document).on('click', '.btn-save-page', function () {
        console.log('save');
        // let data = new FormData()
        // data.append('page', $('#app').html())

        // let code = $('.page.active [name=code]').val()
        // console.log(code);

        $.post('/add.page', {
            html: $('#app').clone().removeClass('teaser-builder')[0].outerHTML,
            code: $('.page.active [name=code]').val()
        }).done(res => {
            console.log(res);
        })

        alert('페이지가 적용(등록)되었습니다. \n다시 로그인 시 가장 최근에 적용된 페이지가 팝업으로 보여집니다. \n* 팝업을 허용해야지만 정상 작동합니다.')
    })

    /* 파일 업로드 */

    $(document).on('input', '.modal [type=file]', function () {
        if ($(this).val()) {
            // $(this).prev().text($(this).val().split('\\').pop())

            let form = $(this).parents('form')
            let formData = new FormData(form[0])

            $this = form.find('[name=file]')

            for (let file of formData.values()) {
                if (file instanceof Blob) {
                    let reader = new FileReader()
                    reader.onload = () => {
                        let result = reader.result
                        $this.val(result).attr('value', result)
                    }
                    reader.readAsDataURL(file)
                }
            }
        }
    })
    $(document).on('submit', '.modal form', function () {
        if ($(this).find('[name=file]').val()) {
            let temp = $(this).next().find('>*:last-child')
            let name = temp.attr('alt')

            let count = 1
            if ($(this).attr('data-count')) {
                count = Number($(this).attr('data-count')) + 1
            }

            $(this).attr('data-count', count)

            let src = '/uploads/' + name + '/' + name + count + '.png'
            $(this).next().append(temp.clone().attr('src', src).addClass('d-none'))
        }
    })

    /* 윈도우가 (탭 종료, 새로 고침, 브라우저 종료 될때 실행) 정보 저장 */
    $(window).on('beforeunload', function (e) {
        if (localStorage.close) {
            localStorage.html = $('body').html()

            localStorage.focus = $(':focus').index('*')
            // let selObj = window.getSelection()
            // localStorage.offset = selObj.anchorOffset
            // localStorage.sel = selObj.toString()

            localStorage.scroll = $(window).scrollTop();
            localStorage.left = $('.tool-box.left-box').scrollTop();
            localStorage.right = $('.tool-box.right-box').scrollTop();
            localStorage.modal0 = $('.modal:eq(0) .modal-body').scrollTop();
            localStorage.modal1 = $('.modal:eq(1) .modal-body').scrollTop();
            localStorage.modal2 = $('.modal:eq(2) .modal-body').scrollTop();
        }
        localStorage.close = 'true'

        /* 여기서 input 들의 값을 실시간으로 attr value 에 넣지말고, 이 저장하는 순간에 넣어주어도 괜찮을 듯. */
        /* 그러나 나중에 넣는 다는 거는.. 끝날때뿐만 아니라 페이지 이동할떄마다 다 넣어줘야 해서 좀 번거로움 두군데에서 해야함.. */

        /* 스크롤 정보를 저장할때 전체 윈도우의 스크롤 각각의 tool-box의 스크롤 정보 값을 저장하고 불러온다. */
    })

    /* 페이지 추가 (정확히는 적용) */
    $(document).on('click', '.btn-add-page', async function () {
        /* 고유코드 */
        let code = 'P' + new Date().getTime();

        let temp = `<div class="page">
            <input class="form-control" type="text" name="name" id="name" placeholder="페이지 이름" value="신규 페이지">
            <div class="d-none">
                <input type="text" name="title" class="form-control" placeholder="타이틀">
                <input type="text" name="desc" class="form-control" placeholder="설명">
                <input type="text" name="keyword" class="form-control" placeholder="키워드">
                <input type="text" name="code" class="form-control" placeholder="고유코드" value="${code}">
                <button class="btn btn-success btn-edit-ok-page w-100 mb-2">확인</button>
            </div>
            <button class="btn btn-success btn-edit-page w-100">페이지수정</button>
        </div>`
        $('.pages').append(temp)

        let header = await fetch('/Header_1.html').then(res => res.text()).then(res => $(res).find('header')[0].outerHTML)
        let footer = await fetch('/Footer_1.html').then(res => res.text()).then(res => $(res).find('footer')[0].outerHTML)

        /* 현재 페이지 저장 */
        let page = $('.page.active')
        if (page.length) {
            localStorage[`page${page.index()}`] = $('#app').html()
            page.removeClass('active')
        }

        /* 갤러리 모달 남기기 */
        let galleryImageModal = $('#app #galleryImageModal')[0].outerHTML

        /* header footer 삽입 (이 순간 전에 있던 정보가 날아간다...) */
        // $('#app').html($(header).addClass('section')).append($('<main>')).append($(footer).addClass('section')).append(galleryImageModal)
        $('#app').html($(header).addClass('section')).append(`<main><div id="visual"></div><div id="features"></div><div id="gallery"></div><div id="contacts"></div></main>`).append($(footer).addClass('section')).append(galleryImageModal)

        /* 추가된 페이지 active */
        $('.page:last-child').click()

        /* DB 에 데이터 등록 */
        $.post('/add.page', {
            html: $('#app').clone().removeClass('teaser-builder')[0].outerHTML,
            code: $('.page.active [name=code]').val()
        }).done(res => {
            console.log(res);
        })

    })

    /* 페이지 선택 */
    $(document).on('click', '.page', function () {
        /*  활성화 비활성화 */
        if (!$(this).hasClass('active')) {
            /* 페이지를 이동할 때 현재 페이지를 저장(업데이트) 후 선택된 페이지 불러오기 */
            let page = $('.page.active')
            if (page.length) {
                localStorage[`page${page.index()}`] = $('#app').html()
                page.removeClass('active')
            }
            $('#app').html(localStorage[`page${$(this).index()}`])
            $(this).addClass('active')

            /* 메뉴 재 등록 */
            $('.menus').html('')

            $(document).find('.section .nav-item .nav-link').filter(function (i, e) {
                // /* 옵션 불러오기 */
                let options = ''
                $('[name=code]').filter(function (ci, ce) {
                    options += `<option value="${$(ce).val()}"`
                    if ('/' + $(ce).val() === $(e).attr('href')) options += 'selected'
                    options += `>${$(ce).val()}</option>`
                })

                let menu = `<li class="menu">
                                <input type="text" class="form-control" placeholder="메뉴이름" value="${$(e).text().trim()}">
                                <select class="custom-select">
                                    <option value="#">URL</option>
                                    ${options}
                                </select>
                            </li>`
                $('.menus').append(menu)
            })

            /* 옵션 초기화 */
            $('.option').hide()

            /* 비주얼 영역 변경 */
            /* 비주얼 영역 가져와서 MODAL 부분의 이미지 active 시키기 */
            $(`.visual-images img`).removeClass('active')
            $(document).find('.carousel-item').filter(function (i, e) {
                let image = $(e).css('backgroundImage')
                image = image.split('/localhost')[1].slice(0, -2)
                console.log(image)

                $(`.visual-images img[src="${image}"]`).addClass('active')
            })

            clearInterval(carouselInterval)
            carouselInterval = setInterval(function () {
                $(document).find('.carousel').carousel('next')
            }, 3000)
        }
    })
    /* 메뉴를 클릭 했을 때.. (URL 변경해주기) */
    $(document).on('input', '.menu select', function () {
        let index = $(this).parents('.menu').index()
        $(`.section .nav-item:eq(${index}) .nav-link`).attr('href', '/' + $(this).val())
    })

    /* 페이지 수정 */
    $(document).on('click', '.btn-edit-page', function () {
        $(this).prev().removeClass('d-none')
        $(this).addClass('d-none')
    })
    /* 페이지 수정 확인 */
    $(document).on('click', '.btn-edit-ok-page', function () {
        $(this).parent().addClass('d-none')
        $(this).parent().next().removeClass('d-none')
    })

    /* 레이아웃 추가 */
    $(document).on('click', '.btn-add-layout', function () {
        /* 템플릿 유형 보여주기 */
        $('.layouts').toggleClass('d-none')
    })
    /* 레이아웃 유형 클릭 */
    $(document).on('click', '.layout', function () {
        $(this).find('ul').toggle()
    })
    /* 레이아웃  삽입 */
    $(document).on('click', '.layout li', async function () {
        if (!$('.page.active').length) {
            alert('페이지를 선택해주세요.')
        } else {
            let id = $(this).text().split('_')[0].toLowerCase()
            id = id.split('&')[0]

            let section = await fetch(`/${$(this).text()}.html`).then(res => res.text()).then(res => $(res).find('section')[0].outerHTML)
            $(`#app main > [id*=${id}]`).replaceWith($(section).addClass('section'))
            // alert('레이아웃이 적용되었습니다.')
        }


    })

    /* section(템플릿) 을클릭하면... (템플릿 추가할 때 생기는 문제점.. 이미 액티브 된 거랑 안된거랑 섞인다. ) */
    $(document).on('click', '.section', function () {
        /* 두번 누르면 해제 가능함.. */
        if ($(this).hasClass('active')) {
            $(this).removeClass('active')
        } else {
            $('.section.active').removeClass('active')
            $(this).addClass('active')

            $('[name=sectionTitle]').val($('.section.active h2').text())
        }

        /* 섹션을 */
        $(`.visual-images img`).removeClass('active')
        $(document).find('.carousel-item').filter(function (i, e) {
            let image = $(e).css('backgroundImage')
            image = image.split('/localhost')[1].slice(0, -2)
            console.log(image)

            $(`.visual-images img[src="${image}"]`).addClass('active')
        })

        clearInterval(carouselInterval)
        carouselInterval = setInterval(function () {
            $(document).find('.carousel').carousel('next')
        }, 3000)

        /* 옵션 모두 숨기기 */
        $('.option').hide()
    })

    /* 옵션 설정 */
    $(document).on('click', '.btn-option', function () {
        let active = $('.section.active')
        if (active.length) {
            let id = active.attr('id').slice(0, -1)

            /* section에 숨기는 것이 있을경우. */
            let showOrHide = $(active).find('.show-or-hide:eq(0) > *')

            // console.log(showOrHide)

            showOrHide.filter(function (i, e) {
                let display = $(e).css('display')

                /* 요소가 보이지 않을 경우, */
                if (display !== 'none') {
                    $(`.option-${id} .show-or-hide > *:eq(${i}) input`).attr('checked', 'checked')
                } else {
                    $(`.option-${id} .show-or-hide > *:eq(${i}) input`).attr('checked', false)
                }
            })

            /* 옵션 변경 (현재 옵션이 아닌것은 숨겨주고 나머지는 토글) */
            $(`.option:not(.option-${id})`).hide()
            $(`.option-${id}`).toggle()

        } else {
            alert('레이아웃을 선택해주세요.');
        }
    })

    /* 헤더 옵션 */
    /* 로고 설정 모달을 열 경우.. */
    $(document).on('click', '.btn-open-logo-modal', function () {
        /* 현재 로고 설정 */
        $('.current-logo').attr('src', $('#app .navbar-brand img').attr('src'))
        $('#logoModal').show()
    })
    /* 로고 변경 */
    $(document).on('click', '.logos img', function () {
        $('.current-logo').attr('src', $(this).attr('src'))
        $('#app .navbar-brand img').attr('src', $(this).attr('src'))
    })

    /* 메뉴 변경*/
    $(document).on('input', '.menu input', function () {
        let val = $(this).val().trim()
        if (!val) val = '이름없음'

        let index = $(this).parent().index()
        $(`.section .nav-item:eq(${index}) .nav-link`).text(val)
    })

    /* 메뉴 추가하기 추가된 요소는 텍스트가 비어있어도 메뉴가 나타남 */
    $(document).on('click', '.btn-add-menu', function () {
        // 다섯개가 아닐경우.. 추가할수 있다.
        if ($('.menu').length !== 5) {
            let index = $('.menu').length + 1

            /* 선택된 부분은 삭제.. */
            let select = $('.menu:last-child select').clone()
            select.find('[selected]').attr('selected', false)

            let temp = `<li class="menu">
                            <input type="text" value="메뉴${index}" class="form-control">
                            ${select[0].outerHTML}
                        </li>`
            $('.menus').append(temp)

            $('.section .navbar-nav').append(`<li class="nav-item"><a href="#" class="nav-link">메뉴${index}</a></li>`)
        } else {
            alert('메뉴는 최대 5개까지 등록가능합니다.')
        }


    })
    /* 메뉴 삭제 */
    $(document).on('click', '.btn-remove-menu', function () {
        // 다섯개가 아닐경우.. 추가할수 있다.
        let len = $('.menu').length
        if (len !== 3) {
            $(`.menus .menu:nth-child(${len})`).remove()
            $(`.section .navbar-nav .nav-item:nth-child(${len})`).remove()
        } else {
            alert('메뉴는 최소 3개는 등록되어야 합니다.')
        }
    })

    /* 비주얼 이미지 선택 */
    $(document).on('click', '.btn-edit-visual-images', function () {
        $('#visualImagesModal').show()
    })
    /* 비주얼 이미지 선택했을때.. */
    $(document).on('click', '.visual-images img', function () {
        /* 선택한 것이 active 된 것일때.. */

        if ($(this).hasClass('active')) {
            if ($('.visual-images img.active').length > 1) {
                $(this).removeClass('active')
            } else {
                alert('마지막 슬라이드 이미지라 선택해제 할 수 없습니다.')
            }
        } else {
            $(this).addClass('active')
        }

        /* 캐러셀 다시 등록 */
        $('.carousel-inner').html('')
        $('.visual-images img.active').filter(function (i, e) {
            let temp = $('<div class="carousel-item"></div>')
                .css('background', `linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url("http://localhost${$(this).attr('src')}") no-repeat center`)
            $('.carousel-inner').append(temp)
        })

        /* 처음 것을 액티브 */
        $('.carousel-item:first-child').addClass('active')

        /* 캐러셀 등록 */
        clearInterval(carouselInterval)
        carouselInterval = setInterval(function () {
            $(document).find('.carousel').carousel('next')
        }, 3000)
    })

    /* 비주얼 내용 변경 (문제가 비주얼을 계속해서 회전해서 텍스트 수정하는게 힘들다...) */
    $(document).on('contextmenu', '.show-or-hide > *', function (e) {
        e.preventDefault()

        /* 수정할 때는 다른 수정가능한 요소는 삭제됨.. */
        $('.show-or-hide [contenteditable=true]').attr('contenteditable', false)

        let chk = true
        $this = $(this)
        if ($this.parent().hasClass('span-edit')) {
            $this = $this.find('span')
            chk = false
        }

        $this.attr('contenteditable', true)
        $this.focus()

        /* 클릭된 요소의 옵션 만들어 주기 */
        $('.option-box').remove()

        let tx = 'translateY(-100%)';
        let tag = $this[0].tagName

        let temp = $(`<div class="option-box" data-target="${tag}"></div>`)

        if (tag === 'A') {
            temp.append(`<input type="text" name="link" class="form-control option-link" value="${$this.attr('href')}" placeholder="URL">`)
        } else if (tag === 'BUTTON') {
            temp.append(`<input type="text" name="link" class="form-control option-link" value="${$this.attr('data-href')}" placeholder="URL">`)
        } else if (tag === 'SPAN' && chk) {
            tx = 'translate(-240px, -100px) scale(.5)';

            let icons = `<div class="option-icon d-flex">`
            for (let i = 0; i < 10; i++) {
                for (let j = 0; j < 7; j++) {
                    let x = i * -61 - 10;
                    let y = j * -71 - 10;
                    icons += `<span class="icon" style="background: url('../images/features/icon.jpg') no-repeat; background-position: ${x}px ${y}px; "></span>`
                }
            }
            icons += '</div>'
            temp.append(icons)
        } else {
            temp.append(`<input type="number" name="fontSize" min="1" value="${parseInt($this.css('font-size'))}" class="form-control-sm option-font-size">`)
            temp.append(`<input type="color" name="textColor" class="form-control-sm option-color" value="${color($this.css('color'))}">`)
        }

        /* 속성.. */
        temp = $(temp).css({
            position: 'absolute',
            left: $this.position().left,
            top: $this.position().top,
            transform: tx
        })

        $this.parent().append(temp)

        $this.unbind()

        /* 포커스를 잃었을 때.. (블러) blur는 버블링을 방지한다... */
        $this.on('blur', function () {
            /* 클릭할 시 */
            $(document).unbind('.close-option')

            /* 옵션을 닫을 때 저장도 같이 해준다..! */
            $(document).on('click.close-option', '*', function (e) {
                /* 버블링 방지 */
                e.stopPropagation()

                // 클릭한것이 option-box 의 내용 아니면..
                if (!$(this).parents('.option-box').length) {
                    $('.option-box').remove()

                    $this.attr('contenteditable', false)
                    $(document).unbind('.close-option')
                    $this.unbind()
                }
            })
        })
    })

    /* 폰트 크기 */
    $(document).on('input', '.option-box .option-font-size', function () {
        let target = $(this).parent().attr('data-target')
        target = $(this).parent().parent().find(target)
        target.css('font-size', $(this).val() + 'px')

        /* span-edit 이면.. */
        if (target.parents('.span-edit').length) {
            target.prev().css('font-size', $(this).val() + 'px')
        }
    })
    /* 텍스트 컬러 */
    $(document).on('input', '.option-box .option-color', function () {
        let target = $(this).parent().attr('data-target')
        target = $(this).parent().parent().find(target)
        target.css('color', $(this).val())

        if (target.parents('.span-edit').length) {
            target.prev().css('color', $(this).val())
        }
    })
    /* 링크 변경 (왜 굳이.. 링크버튼이랑 버튼링크가 있는가..) */
    $(document).on('input', '.option-box .option-link', function () {
        let target = $(this).parent().attr('data-target')
        target = $(this).parent().parent().find(target)

        if (target[0].tagName === 'A') {
            target.attr('href', $(this).val())
        } else {
            target.attr('data-href', $(this).val())
        }
    })
    /* 아이콘 변경 */
    $(document).on('click', '.option-box .option-icon .icon', function () {
        let target = $(this).parents('.option-box').attr('data-target')
        console.log($(this))

        target = $(this).parents('.show-or-hide').find(target)
        target.replaceWith($(this)[0].outerHTML)

        /* 선택 후 삭제 (없어도 한번 클릭하면 삭제 되나.. 박스를 띄우고 새로고침하면 이게 제대로 작동안댐.. 그이유가 context menu event 안에 blur 이벤트 click 이벤트가 있는데 새로 고침하면 blur 이벤트는 언바인딩되서 그런다.)*/
        $('.option-box').remove()
    })

    /* rgb 코드 to hex 코드 */
    function color(rgb) {
        let hexRGB = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
        console.log(hexRGB)

        function hex(x) {
            /* 16 진수로 변환 후 뒤의 2글자를 가져온다.. 만약 한자리수만 반환하면 앞에 0이 붙여져서 나오게된다. */
            return ("0" + parseInt(x).toString(16)).slice(-2);
        }

        if (hexRGB) return "#" + hex(hexRGB[1]) + hex(hexRGB[2]) + hex(hexRGB[3]);
    }

    /* 보이기/숨기기 */
    $(document).on('input', '.option .show-or-hide input', function () {
        let index = $(this).parent().index()
        $(`.section.active .show-or-hide > *:nth-child(${index + 1})`).toggle()
    })

    /* 문단 타이틀 */
    $(document).on('input', '[name=sectionTitle]', function () {
        $('.section.active h2').text($(this).val())
    })

    // let galleryImage = null
    $(document).on('contextmenu', '.card img', function (e) {
        e.preventDefault()

        // galleryImage = $(this)

        let src = $(this).attr('src')

        $('#galleryModal img').removeClass('active')
        $('#galleryModal img').filter(function (i, e) {
            if ($(e).attr('src') === src) {
                $(e).addClass('active')
            }
        })

        $('#galleryModal').show()
        $('#galleryModal').attr('data-target', $(this).parents('.col-3').index())
    })
    $(document).on('click', '#galleryModal .modal-body img', function () {
        $('#galleryModal img.active').removeClass('active')

        $(this).addClass('active')

        let target = $(this).parents('.modal').attr('data-target')
        console.log(target)
        $(`section[id*=gallery] .col-3:eq(${target}) img`).attr('src', $(this).attr('src'))
    })

    /* 클릭 */
    $(document).on('click', '.btn-change-bg', function () {
        $('#formColor').click()
    })

    /* 폼 컬러 변경 */
    $(document).on('input', '#formColor', function () {
        /* 방법1 (로 하면 안됨... 저장되지가 않음.) */
        // document.styleSheets[0].addRule('.section[id*=contacts] form input:valid', `background:  ${$(this).val()} !important;`)
        // document.styleSheets[0].addRule('.section[id*=contacts] form textarea:valid', `background:  ${$(this).val()} !important;`)

        /* 방법2 */
        let style = $('<style></style>').append(`section[id*=contacts] form input:valid, section[id*=contacts] form textarea:valid { background: ${$(this).val()};}`)
        $('#app').append(style)
    })

    $(document).on('click', '.btn-edit-bg', function () {
        $('#bgColor').click()
    })

    /* 푸터 배경 변경 */
    $(document).on('input', '#bgColor', function () {
        $('footer').css('background', $(this).val())
    })


    /* 입력 막기... (같은 type 의 이벤트 일때 순차적으로 내려간다... 알지??) */
    $(document).on('input', '[name=code]', function () {
        /* 영문, 숫자로 이루어져 있지 않을 때.. */
        let index = $(this).parents('.page').index()

        /* eq 는 전체 인덱스라 여러 요소를 한번에 바꾸고 싶다면 nth-chlid 를 사용하자 */
        let option = $(`.menus select option:nth-child(${index + 2})`)

        /* 만약 입력값이 비어있다면... */
        if (!$(this).val()) {
            $(option).hide().attr('selected', false)
            $('.menus select option:first-child').attr('selected', true)
        } else {
            /* 입력값이 영문 및 숫자가 아닐경우... */
            if (!/^[a-zA-Z0-9]+$/.test($(this).val())) {
                alert('고유코드는 영문 및 숫자만 입력가능합니다.')
                $(this).val($(this).attr('value'))
            } else {
                $(option).show().attr('value', $(this).val()).text($(this).val())
            }
        }
    })

    /* 인풋에 남아있는 정보도 저장해준다. (순서 중요.. 이게 아래에 있어서 위에 것이 먼저 먹음) */
    $(document).on('input', 'input', function () {
        $(this).attr('value', $(this).val())
    })

    $(document).on('input', 'textarea', function () {
        $(this).text($(this).val())
    })

    /* select 또한 마찬가지.. */
    $(document).on('input', 'select', function () {
        $(this).find('> option').attr('selected', false)
        $(this).find('> option:selected').attr('selected', true)
    })

    /* checkbox 또한.., 라디오또한.. */
    $(document).on('input', 'input[type=checkbox], input[type=radio]', function () {
        if ($(this).prop('checked')) {
            $(this).attr('checked', true)
        } else {
            $(this).attr('checked', false)
        }
    })
}