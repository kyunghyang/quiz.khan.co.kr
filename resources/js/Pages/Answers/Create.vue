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
                            <a href="/answers/create" @click.prevent="form.get('/answers/create')" class="active" data-tab="maintab_1">
                                퀴즈 풀기
                                <i class="xi-angle-down"></i>
                            </a>
                            <a href="/answers" @click.prevent="form.get('/answers')" class="" data-tab="maintab_2">
                                퀴즈 랭킹
                                <i class="xi-angle-down"></i>
                            </a>
                            <a href="#" class="" data-tab="maintab_3"  @click.prevent="form.get('/answers/questions')">
                                퀴즈 내역
                                <i class="xi-angle-down"></i>
                            </a>
                        </ul>

                        <div class="tab_content active" id="maintab_1">
                            <div class="khquiz_area">

                                <!-- 출제된 퀴즈가 없을 때 -->
                                <div class="info_list_area" v-if="questions.data.length === 0">
                                    <p class="hl" >
                                        오늘 출제된 퀴즈가 없어요! <br>
                                        다음에 이용해 주세요.
                                    </p>
                                </div>
                                <!-- //출제된 퀴즈가 없을 때 -->

                                <!-- 퀴즈풀기 -->
                                <div class="quizlist" v-for="(question, index) in questions.data" :key="question.id" v-if="index == form.activeIndex && !question.answer">
                                    <div class="quiz_q">
                                        <p>
                                            Q.
                                            <span>{{ question.title }}</span>
                                        </p>
                                    </div>
                                    <div class="quiz_a">
                                        <div class="quiz_a_main">
                                            <!-- <div class="quiz_state">
                                                <p class="wrong">오답입니다. 다음 문제에 도전해보세요.</p>
                                                <p class="correct">정답입니다!  경험치 +<span>2</span> 를 획득하셨습니다!</p>
                                            </div> -->
                                            <ul class="quiz_obj">
                                                <li v-for="option in question.options" :key="option.id">
                                                    <label :for="option.id">
                                                        <input type="radio" :id="option.id" name="quiz_obj" :value="option.id" v-model="form.option_id">
                                                        <div class="col-group">
                                                            <p>
                                                                {{ option.title }}
                                                            </p>
                                                            <div class="check_icon">
                                                                <span class="correct">
                                                                    <i class="xi-check"></i>
                                                                </span>
                                                                <!-- <span class="wrong">
                                                                    <i class="xi-close"></i>
                                                                </span> -->
                                                            </div>
                                                        </div>
                                                    </label>
                                                </li>
                                            </ul>
                                            <div class="btn_wrap">
                                                <a href="#" class="next" @click="store(question)">정답 확인하기</a>
                                            </div>
                                        </div>
                                        <div class="quiz_btm" v-if="question.url">
                                            <a :href="question.url" target="_blank">관련 기사 보러가기
                                                <span class="point"><i class="xi-arrow-right"></i>{{question.title_url}}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- //퀴즈풀기 -->

                                <!-- 정답확인 -->
                                <div class="quizlist" v-for="(question, index) in questions.data" :key="question.id" v-if="index == form.activeIndex && question.answer">
                                    <div class="quiz_q">
                                        <p>
                                            Q.
                                            <span>{{ question.title }}</span>
                                        </p>
                                        <a href="#" class="btn-explain" @click="activeExplainPop = !activeExplainPop">해설보기</a>
                                    </div>
                                    <div class="quiz_a">
                                        <div class="quiz_a_main">
                                            <div class="quiz_exp" v-if="activeExplainPop">
                                                <h3>
                                                    {{ question.title }}
                                                </h3>
                                                <p>
                                                    {{question.explain}}
                                                </p>
                                            </div>
                                            <div class="quiz_state">
                                                <!--  -->
                                                <p class="correct" v-if="question.answer.point > 0">정답입니다!  경험치 +<span>{{question.answer.point}}</span> 를 획득하셨습니다!</p>
                                                <p class="wrong" v-else>오답입니다. 다음 문제에 도전해보세요.</p>
                                            </div>
                                            <ul class="quiz_obj">
                                                <li :class="optionClass(question.answer, option)"  v-for="option in question.options" :key="option.id"> <!-- 오답일시 correct 클래스 부여 -->
                                                    <label :for="option.id">
                                                        <input type="radio" :id="option.id" name="quiz_correct" v-if="option.correct" checked disabled>
                                                        <input type="radio" :id="option.id" name="quiz_correct" v-else-if="question.answer.option_id == option.id" checked disabled>
                                                        <input type="radio" :id="option.id" name="quiz_correct" v-else disabled>
                                                        <div class="col-group">
                                                            <p>
                                                                {{ option.title }}
                                                            </p>
                                                            <div class="check_icon">
                                                                <span class="correct">
                                                                    <i class="xi-check"></i>
                                                                </span>
                                                                <!-- <span class="wrong">
                                                                    <i class="xi-close"></i>
                                                                </span> -->
                                                            </div>
                                                        </div>
                                                    </label>
                                                </li>
                                            </ul>
                                            <div class="btn_wrap">
                                                <a href="#" @click.prevent="activeSharePop = true" class="box-socials-wrap">
                                                    공유하기
                                                    <share :path="`/answers/${question.answer.token}`" v-if="activeSharePop" @close="activeSharePop = false"></share>
                                                </a>
                                                <a href="#" class="next" @click.prevent="next">다음 문제</a>
                                            </div>
                                        </div>
                                        <div class="quiz_btm">
                                            <a :href="question.url" target="_blank">관련 기사 보러가기
                                                <span class="point"><i class="xi-arrow-right"></i>{{question.title_url}}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- //정답확인 -->

                                <!-- 퀴즈 결과 -->
                                <div class="quizlist" v-if="questions.data.length !== 0 && form.activeIndex == questions.data.length">
                                    <div class="quiz_totay">
                                        오늘의 퀴즈 결과 <span>{{questions.data[0].opened_at}}</span>
                                    </div>
                                    <div class="quiz_a_main">
                                        <p class="quiz_total_txt" v-if="user">
                                            <span>{{ user.name }}</span>님, 오늘 <span>{{questions.data.length}}</span>개의 퀴즈 중 <span>{{countCorrect}}</span>개를 맞추셨어요!
                                        </p>
                                        <div class="quiz_graph_wrap">
                                            <p class="quiz_total_num">
                                                <span>{{countCorrect}}</span>/<span>{{questions.data.length}}</span>
                                            </p>
                                            <div class="quiz_graph">
                                                <div class="core" :style="`width:${(countCorrect / questions.data.length) * 100}%`"></div>
                                            </div>
                                        </div>
                                        <div class="btn_wrap">
<!--                                            <a href="#" class="share box-socials-wrap" @click="activeSharePop = true">
                                                공유하기
                                                <share :path="`/answers/create?activeIndex=${form.activeIndex}`" v-if="activeSharePop" @close="activeSharePop = false"></share>
                                            </a>
                                            <a href="#" class="next">다음 문제</a>-->
                                        </div>
                                    </div>
<!--                                    <div class="quiz_btm">
                                        <a :href="question.url" target="_blank">관련 기사 보러가기 <i class="xi-arrow-right"></i></a>
                                    </div>-->
                                </div>
                                <!-- //퀴즈 결과 -->
                            </div>
                        </div>
                    </div>
                    <!-- ** //오늘의 퀴즈 콘텐츠 ** -->


                    <div class="box-bottom-logo">
                        * 제작지원 : <img src="/img/logo_copy.png" alt="">
                    </div>
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

export default {
    components: {Share, Link, Pagination},
    data(){
        return {
            questions: this.$page.props.questions,
            form: this.$inertia.form({
                page: 1,
                question_id: "",
                option_id: "",
                activeIndex: this.$page.props.activeIndex,
                khan_id: this.$page.props.khan_id
            }),
            activeSharePop: false,
            activeExplainPop: false,
            user: this.$page.props.user ? this.$page.props.user.data : "",
        }
    },
    methods:{
        store(question){
      /*      if(!this.form.khan_id)
                return alert("로그인 후 참여해주세요.");*/

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

        move(){
            this.form.get("/questions");
        }
    },

    computed: {
        countCorrect() {
            let count = 0;

            this.questions.data.map(question => {
                if(question.answer && question.answer.point > 0)
                    count += 1;
            });

            return count;
        }
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
