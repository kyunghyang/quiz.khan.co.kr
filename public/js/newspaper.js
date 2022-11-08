let form = {
    khan_id: "",
    url: "",
    count_text: "",
    category: "",
    title: "",
    description: "",
    img_url: ""
}



$(document).ready(function(){
    // 큐레이션 저장 팝업 노출
    $(".m-btn-curation").click(function(){
        $(".m-pop-curation").show();
    });

    // 기사완독처리 데이터 준비
    let contents = $(".art_body .content_text");

    if(contents.length){
        form.title = $("#article_title").text();
        form.description = "";

        contents.each(function(index, item){
            form.description = form.description + " " + $(item).text();
        });

        form.category = $( 'meta[property="article:sec_id"]' ).attr( 'content' );
        form.count_text = form.description.length;
        form.url = window.location.href;
        form.img_url = $(".art_photo_wrap img").attr("src");
    }
});

window.addEventListener('message', function(e) {
    // iframe 높이 자동조절
    if(e.data.height){
        document.getElementById('m-newspaper').height= e.data.height;

        document.getElementById('m-newspaper').style.overflow = "hidden";
    }

    // 큐레이션 저장요청
    if(e.data.curationForm){
        storeCuration(e.data.curationForm);
    }

    // 닫기요청
    if(e.data.close)
        $(e.data.close).removeClass("active");

    // URL 이동 요청
    if(e.data.url) {
        if(e.data.new){
            window.open(e.data.url);
        }else{
            window.location.href = e.data.url;
        }
    }

    // 로그인 이동 요청
    if(e.data.login) {
        window.location.href = "https://member.khan.co.kr/login.html?url="+encodeURIComponent(window.location.href);
    }

    // 큐레이션 팝업창 오픈요청
    if(e.data.activeCurationForm)
        $(".m-pop-curation").addClass("active");
});

function storeCuration(curationForm){
    axios.post("https://quiz.khan.co.kr/api/newspapers", {
        ...form,
        ...curationForm
    }).then(response => {
        alert(response.data.message);
    });

    $(".m-pop-curation").removeClass("active");
}

function intersect(khan_id){
    form.khan_id = khan_id;

    let option = {
        root: null,
        rootMargin:"0px",
        threshold: 0.3
    };

    let io = new IntersectionObserver((entries, observer) => {
        entries.forEach((entry) => {
            if(entry.isIntersecting){
                axios.post("https://quiz.khan.co.kr/api/readHistories", form)
                    .then(response => {
                        if(response.data.message)
                            alert(response.data.message);
                    });
            }
        });
    }, option);

    document.querySelectorAll('.share-fn-wrap').forEach((wrapper) => io.observe(wrapper));
}

function flash(text){
    let html = '<div class="m-pop-flash"><div class="m-pop-flash-inner">' + text +'</div></div>';

    $("body").append(html);

    setTimeout(function(){
        $(".m-pop-flash").remove();
    }, 1800);
}