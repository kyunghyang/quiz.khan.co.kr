<template>
    <div class="container">
        <div class="wrap cont">
            <article class="body">

                <!-- **큐레이션** -->
                <div class="mypagecuration khmypage">
                    <h3 class="title">
                        큐레이션
                    </h3>
                    <form action="" @submit.prevent="filter">
                        <div class="search_box">
                            <input type="text" placeholder="큐레이션 제목으로 검색하세요." v-model="form.word">
                            <button type="submit" class="search_btn">
                                <i class="xi-search"></i>
                            </button>
                        </div>
                    </form>

                    <div class="curationarea">
                        <div class="curation_top">
                            <p class="curation_total">
                                총 <span>{{countTotal}}</span> 건의 큐레이션
                            </p>

                            <ul class="curation_menu">
                                <li class="curation_edit" v-if="!editMode">
                                    <a href="#" @click.prevent="edit">
                                        편집하기 <i class="xi-pen-o"></i>
                                    </a>
                                </li>

                                <li class="curation_edit" v-if="editMode">
                                    <a href="#" @click.prevent="destroy">삭제 <i class="xi-trash-o"></i></a>
                                </li>
                                <li class="curation_edit" v-if="editMode">
                                    <a href="#" @click.prevent="update">저장 <i class="xi-save"></i></a>
                                </li>
                                <li class="curation_edit" v-if="editMode">
                                    <a href="#" @click.prevent="cancel">취소 <i class="xi-close"></i></a>
                                </li>
                            </ul>
                        </div>

                        <div class="info_list_area" v-if="items.data.length === 0">
                            <div class="hl" v-if="$page.props.word">
                                일치하는 검색 결과가 없습니다.

                                <div style="margin-top:10px; text-align: center; ">
                                    <button class="btn" style="text-decoration: underline; color:#18497d;" @click="form.word=''; filter()">이전으로</button>
                                </div>

                            </div>
                            <p class="hl" v-else>
                                아직 생성된 큐레이션이 없습니다. <br>
                                큐레이션을 만들고 기사를 저장해 보세요!
                            </p>
                        </div>

                        <ul class="curation_list" v-if="!editMode">
                            <li v-for="item in items.data" :key="item.id">
                                <a href="#" @click="move(item)" class="curation_box">
                                    <div class="img_box">
                                        <img :src="item.img_url" class="thumb_g" alt="">
                                    </div>
                                    <p class="curation_title">{{item.title}}</p>
                                </a>
                            </li>

                            <li class="curation_add" @click="active = true;" v-if="!$page.props.word">
                                <p>
                                    <i class="xi-plus"></i>
                                    큐레이션 만들기
                                </p>
                            </li>
                        </ul>

                        <ul class="curation_list edit" v-else>
                            <li v-for="(item, index) in items.data" :key="item.id">
                                <div class="curation_select">
                                    <label :for="item.id">
                                        <input type="checkbox" :value="item.id" :id="item.id" name="curation_select" v-model="form.selected_ids">
                                        <span class="select_icon"><i class="xi-check"></i></span>
                                    </label>
                                </div>
                                <div class="curation_box">
                                    <div class="img_box">
                                        <img :src="item.img_url" class="thumb_g" alt="">
                                    </div>
                                    <p class="curation_title" v-if="!editMode">{{item.title}}</p>
                                    <input type="text" placeholder="문화 예술 모음" @change="e => changeTitle(e, index)" v-if="editMode" :value="item.title">
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!--// **큐레이션** -->

                <!-- 큐레이션 생성 -->
                <div class="kh_popup" v-if="active">
                    <div class="popup_box">
                        <p class="popup_title">
                            큐레이션 만들기
                        </p>
                        <div class="popup_con">
                            <input type="text" :placeholder="today" v-model="form.title">
                        </div>
                        <div class="btn_wrap">
                            <button type="button" class="popup_btn cancel" @click="active = false;">취소</button>
                            <button type="button" class="popup_btn" @click="store">만들기</button>
                        </div>
                    </div>
                </div>
                <!-- // 큐레이션 생성 -->
            </article>
        </div>
    </div>
</template>
<script>
import {Link} from '@inertiajs/inertia-vue';
import Pagination from "../../Components/Pagination";

export default {
    components: {Link, Pagination},
    data() {
        return {
            items: this.$page.props.items,
            countTotal: this.$page.props.countTotal,
            today: this.$page.props.today,
            form: this.$inertia.form({
                page: 1,
                title: "",
                word: this.$page.props.word,
                selected_ids: [],
                khan_id: this.$page.props.khan_id,
                curations: [],
            }),
            origin: [],
            active: false,
            editMode: false,
        }
    },
    methods: {
        filter() {
            this.form.get("/curations", {
                preserveState: true,
                preserveScroll: true,
                onSuccess: (page) => {
                    this.items = page.props.items;
                }
            });
        },

        changeTitle(e, index) {
            this.items.data[index].title = e.target.value;
        },

        store() {
            this.form.post("/curations", {
                preserveState: true,
                preserveScroll: true,

                onSuccess: (page) => {
                    this.items = page.props.items;

                    this.form.title = "";
                    this.form.selected_ids = [];

                    flash("큐레이션 생성 완료! 기사를 저장하고 템플릿을 꾸며보세요.");
                }
            });

            this.active = false;
        },
        update(){
            this.form.curations = this.items.data;

            this.form.patch("/curations", {
                preserveState: true,
                preserveScroll: true,

                onSuccess: (page) => {
                    this.items = page.props.items;

                    this.form.curations = [];

                    this.form.selected_ids = [];
                    this.editMode = false;

                    this.active = false;

                    flash("큐레이션 수정 완료!");
                }
            });
        },
        destroy(){
            if(this.form.selected_ids.length === 0)
                return alert('최소 1개 이상 선택해주세요.');

            this.items.data = this.items.data.filter(item => !this.form.selected_ids.includes(item.id));
            /*this.form.delete("/curations", {
                preserveScroll: true,
                preserveState: true,
                onSuccess: (page) => {
                    this.items = page.props.items;

                    this.form.title = "";
                    this.form.selected_ids = [];
                }
            })*/
        },

        move(item){
            this.form.get(`/curations/${item.token}?khan_id=${this.form.khan_id}`);
        },

        edit(){
            this.origin = JSON.parse(JSON.stringify(this.items.data));

            this.editMode = true;
        },

        cancel(){
            this.items.data = JSON.parse(JSON.stringify(this.origin));

            this.form.selected_ids = [];

            this.editMode = false;
        }
    },

    mounted() {
        this.items.data.map(item => {
            this.form.curations.push({
                id: item.id,
                title: item.title,
            })
        })
    }
}
</script>
