<?php
$data = $pdo->query("select * from excel");
?>

<section id="invites">
    <div class="container">
        <div class="row">
            <div class="col-2">
                <div class="box ">
                    <div>
                        <button class="btn btn-primary" onclick="location.href='/invite'">등록폼 으로</button>
                    </div>
                    <div>
                        <button class="btn btn-primary" onclick="location.href='/download'">엑셀로 다운로드</button>
                    </div>
                </div>
            </div>
            <div class="col-10">
                <div class="box">
                    <div class="table">
                        <table>
                            <tr>
                                <th>행사명</th>
                                <th>초청일련번호</th>
                                <th>초청자명</th>
                                <th>이메일 주소</th>
                                <th>초대장미리보기</th>
                            </tr>
                            <?php foreach ($data as $item) { ?>
                                <tr>
                                    <td>행사명입니다</td>
                                    <td><?= $item->num ?></td>
                                    <td><?= $item->name ?></td>
                                    <td><?= $item->email ?></td>
                                    <td>
                                        <button class="btn btn-primary" onclick="inviteView(this)">초대장미리보기</button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>

                        <form method="post" class="mt-5">
                            <input type="text" placeholder="초청일련번호" required name="num" class="form-control mb-3">
                            <input type="text" placeholder="초청자명" required name="name" class="form-control mb-3">
                            <input type="text" placeholder="이메일 주소" required name="email" class="form-control mb-3">
                            <button class="btn btn-primary w-100">추가하기</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function inviteView(obj) {
        let el = $(obj);
        let tr = el.parents('tr');
        let num = tr.find('td').eq(1).text();
        let name = tr.find('td').eq(2).text();
        let email = tr.find('td').eq(3).text();
        let html = `
				<div class="layer" onclick="$(this).remove()" style="cursor:pointer">
					<div class="box">
						<h3 class="mt-4 mb-4">
							온라인 초대장
						</h3>
						<div style="width:100%; height:1px; background:#ddd;"></div>
						<div class="d-flex mt-3 mb-3 justify-content-between" style="width:400px;">
							<p><b>초청일련번호</b></p>
							<p>${num}</p>
						</div>
						<div class="d-flex mt-3 mb-3 justify-content-between" style="width:400px;">
							<p><b>이름</b></p>
							<p>${name}</p>
						</div>
						<div class="d-flex mt-3 mb-3 justify-content-between" style="width:400px;">
							<p><b>초청자이메일</b></p>
							<p>${email}</p>
						</div>
					</div>
				</div>
			`;
        $(html).appendTo('body');
    }
</script>