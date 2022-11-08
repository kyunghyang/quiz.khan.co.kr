<template>
    <div class="box-socials">
        <button class="btn-close" @click="close">
            <img src="/img/x.png" alt="">
        </button>

        <div class="btns">
            <a id="btnTwitter" class="link-icon twitter" @click.prevent="shareTwitter">
                <img src="/img/icon-twitter.png" alt="">
            </a>
            <a id="btnFacebook" class="link-icon facebook" @click.prevent="shareFacebook">
                <img src="/img/icon-facebook.png" alt="">
            </a>
            <a id="btnKakao" class="link-icon kakao" @clic.prevent="close">
                <img src="/img/icon-kakao.png" alt="">
            </a>
        </div>
    </div>
</template>
<script>
import {Link} from '@inertiajs/inertia-vue';
export default {
    components: {Link},
    props: ["path"],
    data(){
        return {
            domain: this.$page.props.domain,
            parent_url: this.$page.props.parent_url,
            url: ""
        }
    },
    methods: {
        shareTwitter() {
            var sendText = "경향신문"; // 전달할 텍스트

            window.open("https://twitter.com/intent/tweet?text=" + sendText + "&url=" + this.url + "/?utm_source=twitter&utm_medium=social&utm_content=sharing_curation");
            this.close();
        },
        shareFacebook() {
            window.open("http://www.facebook.com/sharer/sharer.php?u=" + this.url + "/?utm_source=facebook&utm_medium=social&utm_content=sharing_curation");
            this.close();

        },
        initKakao() {
            let url = this.domain + "/share" + this.path + "/?utm_source=kakaostory&utm_medium=social&utm_content=sharing_curation";

            // 사용할 앱의 JavaScript 키 설정


            // 카카오링크 버튼 생성
            Kakao.Link.createDefaultButton({
                container: '#btnKakao', // 카카오공유버튼ID
                objectType: 'feed',
                content: {
                    title: "경향신문", // 보여질 제목
                    description: "경향신문", // 보여질 설명
                    imageUrl: url, // 콘텐츠 URL
                    link: {
                        mobileWebUrl: url,
                        webUrl: url
                    }
                }
            });
        },

        close(e){
            e.stopPropagation();
            e.preventDefault();

            this.$emit("close");
        }
    },
    computed: {
    },

    mounted() {
        this.url = this.parent_url + this.path;

        this.initKakao();
    }
}
</script>
<!--<script>
import {Link} from '@inertiajs/inertia-vue';
export default {
    components: {Link},
    props: ["path"],
    data(){
        return {
            domain: this.$page.props.domain,
            parent_url: this.$page.props.parent_url,
            url: ""
        }
    },
    methods: {
        shareTwitter() {
            var sendText = "경향신문"; // 전달할 텍스트

            window.open("https://twitter.com/intent/tweet?text=" + sendText + "&url=" + this.url);
            this.close();
        },
        shareFacebook() {
            window.open("http://www.facebook.com/sharer/sharer.php?u=" + this.url);
            this.close();

        },
        initKakao() {
            let url = this.domain + "/share" + this.path;

            // 사용할 앱의 JavaScript 키 설정


            // 카카오링크 버튼 생성
            Kakao.Link.createDefaultButton({
                container: '#btnKakao', // 카카오공유버튼ID
                objectType: 'feed',
                content: {
                    title: "경향신문", // 보여질 제목
                    description: "경향신문", // 보여질 설명
                    imageUrl: url, // 콘텐츠 URL
                    link: {
                        mobileWebUrl: url,
                        webUrl: url
                    }
                }
            });
        },

        close(e){
            e.stopPropagation();
            e.preventDefault();

            this.$emit("close");
        }
    },
    computed: {
    },

    mounted() {
        this.url = this.parent_url + this.path;

        this.initKakao();
    }
}
</script>-->
