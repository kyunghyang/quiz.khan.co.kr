<template>
    <div>
        <img src="https://img.khan.co.kr/images/khan/pc/ico-fn-star-on.svg" alt="" v-if="!active && already" @click="alert" style="width:22px; cursor:pointer;">
        <img src="https://img.khan.co.kr/images/khan/pc/ico-fn-star-off.svg" alt="" v-if="!active && !already" style="width:22px; cursor:pointer;" @click="activePop">

        <div class="kh_popup" v-if="active && $page.props.khan_id">
            <div class="popup_box">
                <p class="popup_title">
                    큐레이션 저장
                </p>
                <div class="popup_con">
                    <div class="curation_container">
                        <ul class="curation_list">
                            <li v-for="curation in curations.data" :key="curation.id" style="cursor:pointer" @click="select(curation)" :class="`${form.curation_ids.includes(curation.id) ? 'active' : ''}`">
                                <div class="curation_select">
                                    <label :for="curation.id">
                                        <input type="checkbox" :id="curation.id" name="curation_select">
                                        <span class="select_icon">
                                            <i class="xi-check"></i>
                                        </span>
                                    </label>
                                </div>
                                <div class="curation_box">
                                    <div class="img_box">
                                        <img :src="curation.img_url ? curation.img_url : ''" class="thumb_g" alt="">
                                    </div>
                                </div>
                                <h3 class="title">{{curation.title}}</h3>
                            </li>
                            <li class="curation_add" @click="move">
                                <p>
                                    <i class="xi-plus"></i>
                                    큐레이션 만들기
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="btn_wrap">
                    <button type="button" class="popup_btn" @click="store">저장</button>
                    <button type="button" class="popup_btn close" @click="close">취소</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {Link} from '@inertiajs/inertia-vue';
import Pagination from "../../Components/Pagination";
import Share from "../../Components/Share";

export default {
    components: {Share, Link, Pagination},
    data() {
        return {
            active: false,
            already: this.$page.props.already,
            auth: this.$page.props.user ? this.$page.props.user.data : "",
            curations: this.$page.props.curations,
            url:this.$page.props.url,
            form: {
                khan_id: this.$page.props.khan_id,
                curation_ids: [],
            }
        }
    },
    methods: {
        store(curation) {
            if(this.form.curation_ids.length === 0)
                return alert("큐레이션을 선택해주세요.");

            let self = this;

            axios.post("https://quiz.khan.co.kr/api/newspapers", {
                curation_ids: this.form.curation_ids,
                khan_id: this.form.khan_id
            }).then(response => {

            });

            window.parent.postMessage({ curationForm : this.form }, "*");

            this.active = false;

            location.reload();
        },

        select(curation){
            let found_curation_id = this.form.curation_ids.find(curation_id => curation.id == curation_id);

            if(found_curation_id){
                this.form.curation_ids = this.form.curation_ids.filter(curation_id => curation_id != curation.id);
            }else{
                this.form.curation_ids.push(curation.id);
            }
        },

        move(){
            window.parent.postMessage({
                new: 1,
                url : "https://member.khan.co.kr/mypage/more/my_curations.html"}, "*"
            );
        },

        close(){
            this.active = false;
            window.parent.postMessage({ close : ".m-pop-curation" }, "*");
        },

        alert() {
            alert("이미 큐레이션에 저장된 기사입니다.");
        },

        activePop(){
            if(!this.auth) {
                window.parent.postMessage({ login: true  }, "*");

                // return alert("큐레이션 기능은 로그인이 필요합니다.");
            }

            window.parent.postMessage({ activeCurationForm: true }, "*");

            this.active = true;
        }
    },

    mounted() {
    }
}
</script>
