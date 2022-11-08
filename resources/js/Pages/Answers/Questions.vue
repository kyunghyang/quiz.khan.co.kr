Create.vue<template>

    <div class="container sub">

        <!-- 현재 위치 -->
        <!--
        <div class="breadcrumb">
            <span><a href="https://www.khan.co.kr" title="경향신문">경향신문</a></span>
            <span>
					<a href="#" title="오늘의 퀴즈">
                        <strong>오늘의 퀴즈</strong>
                    </a>
				</span>
        </div>
        -->
        <!-- // 현재 위치 -->


        <!-- section -->
        <div class="section">
            <!-- inner -->
            <div class="inner">
                <!-- cont-main -->
                <div class="cont-main">
                    <div class="title-wrap">
                        <h3 class="sct_tit"> 오늘의 퀴즈 </h3>
                    </div>

                    <!-- ** 오늘의 퀴즈 콘텐츠 ** -->
                    <div class="khquiz khrank mainarea">
                        <ul class="maintab">
                            <a href="/answers/create" @click.prevent="form.get('/answers/create')" data-tab="maintab_1">
                                퀴즈 풀기
                                <i class="xi-angle-down"></i>
                            </a>
                            <a href="/answers" @click.prevent="form.get('/answers')" class="" data-tab="maintab_2">
                                퀴즈 랭킹
                                <i class="xi-angle-down"></i>
                            </a>
                            <a href="#" class="active" data-tab="maintab_3"  @click.prevent="form.get('/answers/questions')">
                                퀴즈 내역
                                <i class="xi-angle-down"></i>
                            </a>
                        </ul>

                        <div class="tab_content active" id="maintab_1">
                            <!-- **퀴즈내역** -->
                            <div class="mypagequiz khmypage">
                                <h3 class="title">
                                    퀴즈내역
                                </h3>
                                <form action="" @click.prevent="filter">
                                    <div class="search_box">
                                        <input type="text" placeholder="퀴즈 제목으로 검색하세요." v-model="form.word">
                                        <button type="submit" class="search_btn">
                                            <i class="xi-search"></i>
                                        </button>
                                    </div>
                                </form>

                                <div class="quizarea">
                                    <ul class="quizmenu mypagetab">
                                        <li :class="form.correct === '' ? 'active' : ''" @click="form.correct = ''; filter()">
                                            전체 <span>{{ countTotal }}</span>
                                            <i class="xi-angle-down"></i>
                                        </li>
                                        <li :class="form.correct === 1 || form.correct === '1' ? 'active' : ''" @click="form.correct = 1; filter()">
                                            맞춘 퀴즈 <span>{{ countCorrect }}</span>
                                            <i class="xi-angle-down"></i>
                                        </li>
                                        <li :class="form.correct === 0 || form.correct === '0' ? 'active' : ''" @click="form.correct = 0; filter()">
                                            틀린 퀴즈 <span>{{ countIncorrect }}</span>
                                            <i class="xi-angle-down"></i>
                                        </li>
                                    </ul>

                                    <ul class="quiz_a_top" v-if="user">
                                        <li>
                                            <p>정답률 : <span>{{ user.ratio_correct }}</span>%</p>
                                        </li>
                                        <li>
                                            <p>총 획득 경험치 : <span>{{ user.count_quiz_point }}</span></p>
                                        </li>
                                    </ul>

                                    <div class="quizlist_wrap tab_content active" id="quizmenu_1">
                                        <div class="info_list_area" v-if="items.data.length === 0">


                                            <div class="hl" v-if="$page.props.word">
                                                일치하는 검색 결과가 없습니다.

                                                <div style="margin-top:10px; text-align: center; ">
                                                    <button class="btn" style="text-decoration: underline; color:#18497d;" @click="form.word=''; filter()">이전으로</button>
                                                </div>

                                            </div>

                                            <p class="hl" v-else>
                                                아직 퀴즈 내역이 없습니다. <br>
                                                오늘의 퀴즈 페이지에서 퀴즈를 풀어보세요!
                                            </p>
                                        </div>




                                        <ul class="quizlist">

                                            <question v-for="item in items.data" :key="item.id" :item="item" />
                                        </ul>

                                        <pagination :meta="items.meta" @paginate="(page) => {form.page = page; filter()}" />

                                        <div class="box-bottom-logo">
                                            * 제작지원 : <img src="/img/logo_copy.png" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--// **퀴즈내역** -->
                        </div>
                    </div>
                    <!-- ** //오늘의 퀴즈 콘텐츠 ** -->

                </div>
                <!-- // cont-main -->

            </div>
            <!-- // inner -->
        </div>
        <!-- // section -->
    </div>


</template>
<script>
import {Link} from '@inertiajs/inertia-vue';
import Pagination from "../../Components/Pagination";
import Share from "../../Components/Share";
import Question from "../../Components/Question";

export default {
    components: {Question, Share, Link, Pagination},
    data(){
        return {
            questions: this.$page.props.questions,
            form: this.$inertia.form({
                page: 1,
                question_id: "",
                option_id: "",
                activeIndex: this.$page.props.activeIndex,
                khan_id: this.$page.props.khan_id,

                word: this.$page.props.word,
                correct: this.$page.props.correct
            }),
            activeSharePop: false,
            activeExplainPop: false,
            user: this.$page.props.user ? this.$page.props.user.data : "",

            items: this.$page.props.items,
            countTotal : this.$page.props.countTotal,
            countCorrect : this.$page.props.countCorrect,
            countIncorrect : this.$page.props.countIncorrect,
            countTotalPoint : this.$page.props.countTotalPoint,
        }
    },
    methods:{
        store(question){
            if(!this.form.khan_id)
                return alert("로그인 후 참여해주세요.");

            this.form.question_id = question.id;

            this.form.post("/answers", {
                preserveState: true,
                preserveScroll: true,
                onSuccess: (page) => {
                    this.questions = page.props.questions;
                }
            });
        },

        next(){
            this.activeExplainPop = false;
            this.form.activeIndex = parseInt(this.form.activeIndex) + 1;


        },

        optionClass(answer, option){
            if(option.correct)
                return "correct";

            if(answer.option_id == option.id && answer.point == 0)
                return "wrong";

            return "";
        },

        filter(){
            this.form.get("/answers/questions", {
                preserveScroll: true,
                preserveState: true,
                onSuccess: (page) => {
                    this.items = page.props.items;
                }
            });
        },

        move(){
            this.form.get("/questions");
        }
    },

    computed: {
        /*countCorrect() {
            let count = 0;

            this.questions.data.map(question => {
                if(question.answer && question.answer.point > 0)
                    count += 1;
            });

            return count;
        }*/
    },

    mounted() {
        //탭 링크
        $('.maintab li').click(function(){
            $(".maintab li").removeClass("active");
            $(this).addClass("active");
            var tab_id = $(this).attr('data-tab');
            $('.tab_content').removeClass('active');

            $(".tab_content#"+tab_id).addClass('active');
        });

        $(".btn-explain").click(function(){
            $(this).parents(".quizlist").find(".quiz_exp").show();
        });
    }
}
</script>
