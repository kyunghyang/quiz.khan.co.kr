<template>
    <div class="container curations-show"
         :style="`min-height:100vh; padding:0; background:url('${user.template.img_background ? user.template.img_background.url : ''}'); background-size:cover; background-position:center;`">
        <div class="wrap cont" style="padding:80px 0px;">
            <article class="body" style="background-color:rgba(255,255,255,0.9);">
                <!-- **큐레이션** -->
                <div class="mypagecuration_detail khmypage">
                    <button style="display:flex; align-items:center;  color:#18497d;" @click="back" v-if="auth && auth.id == user.id">
                        <i class="xi-arrow-left" style="margin-right:8px;"></i>목록보기
                    </button>

                    <div style="margin-bottom:10px;"></div>

                    <h3 class="title" v-if="!curationEditMode" style="display:flex; align-items: center;">
                        {{ curation.title }}

                        <!--
                        <i class="xi-pen-o" style="margin-left:8px; font-size:18px; color:#999; cursor:pointer;" @click="curationEditMode = true"  v-if="auth && auth.id == user.id" ></i>
                        -->
                    </h3>
                    <h3 class="title" v-else>
                        <div class="m-input-text type01" style="display:flex; align-items: center;">
                            <input type="text" v-model="curationForm.title" style="max-width:250px;">

                            <i class="xi-save m-input-text-deco"
                               style="margin-left:8px; font-size:18px; color:#999; cursor:pointer;"
                               @click="updateCuration"></i>

                        </div>

                    </h3>
                    <form action="" @submit.prevent="update">

                        <div class="curationarea">
                            <div class="curation_top" v-if="auth && auth.id == user.id">
                                <ul class="curation_menu">
                                    <li class="curation_edit" v-if="!editMode">
                                        <a href="#" @click.prevent="edit"
                                           :style="`color:${usingTemplate.color}; background-color:${usingTemplate.background_color}`">
                                            편집하기 <i class="xi-pen-o"></i>
                                        </a>
                                        <!-- <ul class="curation_edit_detail" v-if="editMode">
                                            <li class="curation_del">
                                                <a href="#" @click.prevent="destroy">삭제</a>
                                            </li>
                                            <li>
                                                <a href="#" @click.prevent="update">완료</a>
                                            </li>
                                        </ul> -->
                                    </li>
                                    <li class="curation_edit" v-if="editMode">
                                        <a href="#" @click.prevent="destroy">
                                            삭제
                                            <i class="xi-trash-o"></i>
                                        </a>
                                    </li>
                                    <li class="curation_edit" v-if="editMode">
                                        <a href="#" @click.prevent="updateAll">
                                            저장
                                            <i class="xi-save"></i>
                                        </a>
                                    </li>
                                    <li class="curation_edit" v-if="editMode">
                                        <a href="#" @click.prevent="cancel">
                                            취소
                                            <i class="xi-save"></i>
                                        </a>
                                    </li>

                                    <li class="curation_temp" v-if="!editMode">
                                        <a href="#" @click.prevent="activeTemplatePop = true"
                                           :style="`color:${usingTemplate.color}; background-color:${usingTemplate.background_color}`">
                                            템플릿 선택 <i class="xi-border-all"></i>
                                        </a>
                                    </li>
                                    <li class="curation_share box-socials-wrap" v-if="!editMode">
                                        <a href="#" @click.prevent="activeSharePop = true;"
                                           :style="`color:${usingTemplate.color}; background-color:${usingTemplate.background_color}`">
                                            공유하기 <i class="xi-upload"></i>
                                        </a>
                                        <share v-if="activeSharePop" :path="`/curations/${curation.token}`"
                                               @close="activeSharePop = false"/>
                                    </li>
                                </ul>
                            </div>

                            <div class="m-empty type01" v-if="newspapers.data.length === 0"
                                 style="padding:60px; text-align: center; border:1px solid #e1e1e1; margin-bottom:20px;">
                                등록된 기사가 없습니다.
                            </div>

                            <ul class="curation_detail_list">
                                <li v-for="(newspaper, index) in newspapers.data" :key="newspaper.id">
                                    <a :href="newspaper.url" target="_blank" class="curation_box">
                                        <label :for="newspaper.id" v-if="editMode">
                                            <input type="checkbox" :id="newspaper.id" :value="newspaper.id"
                                                   v-model="form.selected_ids">
                                            <span class="check_icon"><i class="xi-check"></i></span>
                                        </label>
                                        <div class="img_box">
                                            <img :src="newspaper.img_url" class="thumb_g" alt="">
                                        </div>
                                        <div class="txt">
                                            <div class="s-tit">{{ newspaper.created_at }}</div>
                                            <h2 class="tit">{{ newspaper.title }}</h2>
                                            <!--                                            <span class="byline">5시간 전</span>-->
                                            <span class="lead">
                                                {{ newspaper.description }}
                                            </span>
                                        </div>
                                        <div class="arrows type01" v-if="editMode">
                                            <div class="arrow" @click="(e) => prev(e, index)">
                                                <i class="xi-arrow-up"></i>
                                            </div>
                                            <div class="arrow" @click="(e) => next(e, index)">
                                                <i class="xi-arrow-down"></i>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>

                        </div>

                        <div class="search_box_wrap" v-if="editMode">
                            <div class="search_box">
                                <input type="text" placeholder="큐레이션 텍스트를 입력하세요." v-model="form.memo">
                            </div>
                        </div>

                        <div class="search_box_wrap" v-else>
                            <div class="search_box">
                                <input type="text" placeholder="큐레이션 메모" disabled v-model="form.memo">
                            </div>
                        </div>

                    </form>
                </div>
                <!--// **큐레이션** -->

                <div class="kh_popup" v-if="activeTemplatePop && user">
                    <div class="popup_box temp">
                        <h3 class="title">템플릿 선택</h3>

                        <p class="popup_title">
                            모든 템플릿
                        </p>
                        <div class="m-empty type01" v-if="templates.data.length === 0"
                             style="padding:60px; text-align: center; border:1px solid #e1e1e1; margin-bottom:20px;">
                            등록된 템플릿이 없습니다.
                        </div>
                        <div class="popup_con" v-else>
                            <ul class="temp_list">
                                <li class="temp_grade_1" v-for="template in templates.data" :key="template.id">
                                    <label :for="'template' + template.id">
                                        <div class="temp_obj"
                                             :style="template.img_background ? `background:url('${template.img_background.url}'); background-size:cover; background-position:center;` : ''">
                                            <div class="temp_select">
                                                <input type="radio" :id="'template' + template.id" :value="template.id"
                                                       name="temp_default" v-model="form.template_id"
                                                       v-if="user.level < template.level_required" disabled>
                                                <input type="radio" :id="'template' + template.id" :value="template.id"
                                                       name="temp_default" v-model="form.template_id" v-else>
                                                <span class="select_icon non_select"
                                                      v-if="user.level < template.level_required"><i
                                                    class="xi-lock"></i></span>
                                                <span class="select_icon" v-else><i class="xi-check"></i></span>
                                            </div>
                                            <p class="temp_txt"
                                               :style="`color:${template.color ? template.color : ''}; background-color:${template.background_color ? template.background_color : ''}; `">
                                                텍스트 컬러
                                            </p>
                                        </div>
                                        <div class="temp_grade">
                                            <p>
                                                <span>{{ template.level_required }}</span>Lv
                                            </p>
                                        </div>
                                    </label>
                                </li>
                            </ul>
                        </div>

                        <!--
                        <p class="popup_title">
                            벳지
                        </p>
                        <div class="m-empty type01" v-if="templates.data.length === 0"
                             style="padding:60px; text-align: center; border:1px solid #e1e1e1; margin-bottom:20px;">
                            등록된 벳지가 없습니다.
                        </div>
                        <div class="popup_con" v-else>
                            <ul class="temp_list">
                                <li :class="`temp_grade_1 ${template.level_required > user.level ? 'disable' : ''}`"
                                    v-for="template in templates.data" :key="template.id">
                                    <label>
                                        <div class="temp_obj">
                                            <span class="badge"><img
                                                :src="template.img_badge ? template.img_badge.url : ''" alt=""></span>
                                        </div>
                                        <div class="temp_grade">
                                            <p>
                                                <span>{{ template.level_required }}</span>Lv
                                            </p>
                                        </div>
                                    </label>
                                </li>
                            </ul>
                        </div>
                        -->

                        <div class="btn_wrap">
                            <button type="button" class="popup_btn cancel" @click="activeTemplatePop = false">취소
                            </button>
                            <button type="button" class="popup_btn" @click="updateTemplate">저장하기</button>
                        </div>
                    </div>
                </div>

            </article>
        </div>

        <!-- // wrap cont -->
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
            auth: this.$page.props.user ? this.$page.props.user.data : "",
            curation: this.$page.props.curation.data,
            templates: this.$page.props.templates,
            newspapers: this.$page.props.newspapers,
            originNewspapers: "",
            usingTemplate: this.$page.props.curation.data.user.template,
            user: this.$page.props.curation.data.user,
            form: this.$inertia.form({
                khan_id: this.$page.props.khan_id,
                page: 1,
                word: this.$page.props.word,
                selected_ids: [],
                template_id: this.$page.props.curation.data.user.template.id,
                memo: this.$page.props.curation.data.memo,
                newspapers: [],
                curation_id: this.$page.props.curation.data.id,
            }),
            curationForm: this.$inertia.form({
                title: this.$page.props.curation.data.title
            }),
            editMode: false,
            curationEditMode: false,
            activeTemplatePop: false,
            activeSharePop: false,
            origin: [],
            canBack: false,
        }
    },
    methods: {
        filter() {
            this.form.get("/curations/" + this.curation.token, {
                preserveState: true,
                preserveScroll: true,
                onSuccess: (page) => {
                    this.newspapers = page.props.newspapers;
                }
            });
        },

        updateAll() {
            this.form.newspapers = this.newspapers.data;

            this.form.patch(`/newspapers`, {
                preserveScroll: true,
                preserveState: true,
                onSuccess: (page) => {
                    this.newspapers = page.props.newspapers;
                    this.editMode = false;
                    this.form.selected_ids = [];
                }
            })
        },

        update() {
            this.form.patch("/curations/updateMemo/" + this.curation.id, {
                preserveState: true,
                preserveScroll: true,
                onSuccess: (page) => {
                    alert("성공적으로 처리되었습니다.");
                }
            });
        },

        edit(){
            this.origin = JSON.parse(JSON.stringify(this.newspapers.data));

            this.editMode = true;
        },

        cancel(){
            this.newspapers.data = JSON.parse(JSON.stringify(this.origin));

            this.form.selected_ids = [];

            this.editMode = false;

            this.form.memo = this.curation.data.memo;
        },

        next(e, index) {
            e.preventDefault();
            e.stopPropagation();

            let tmp;

            if (this.newspapers.data[index + 1]) {
                tmp = this.newspapers.data[index].order;
                this.newspapers.data[index].order = this.newspapers.data[index + 1].order;
                this.newspapers.data[index + 1].order = tmp;
            }

            this.newspapers.data = this.newspapers.data.sort((a, b) => {
                return a.order - b.order
            });
        },

        prev(e, index) {
            e.preventDefault();
            e.stopPropagation();

            let tmp;

            if (this.newspapers.data[index - 1]) {
                tmp = this.newspapers.data[index].order;
                this.newspapers.data[index].order = this.newspapers.data[index - 1].order;
                this.newspapers.data[index - 1].order = tmp;
            }

            this.newspapers.data = this.newspapers.data.sort((a, b) => {
                return a.order - b.order
            });
            /*
            this.form.patch(`/newspapers/${newspaper.id}/prev`, {
                preserveScroll: true,
                preserveState: true,
                onSuccess: (page) => {
                    this.newspapers = page.props.newspapers;
                }
            })
             */
        },

        destroy() {
            if (this.form.selected_ids.length === 0)
                return alert('최소 1개 이상 선택해주세요.');

            this.newspapers.data = this.newspapers.data.filter(item => !this.form.selected_ids.includes(item.id));

            /*this.form.delete("/newspapers", {
                preserveScroll: true,
                preserveState: true,
                onSuccess: (page) => {
                    this.newspapers = page.props.newspapers;
                    this.form.selected_ids = [];
                }
            })*/
        },

        updateTemplate() {
            this.form.patch("/users/template", {
                preserveScroll: true,
                preserveState: true,
                onSuccess: (page) => {
                    this.activeTemplatePop = false;

                    this.user = page.props.user.data;
                    this.usingTemplate = page.props.user.data.template;
                }
            })
        },

        updateCuration() {
            this.curationForm.patch("/curations/" + this.curation.id, {
                onSuccess: (page) => {
                    this.curationEditMode = false;
                    this.curation = page.props.curation.data;
                }
            });
        },

        back(){
            this.$inertia.get("/curations?khan_id=" + encodeURIComponent(this.$page.props.khan_id));
        }
    },

    mounted() {
        console.log(this.auth);
    }
}
</script>
