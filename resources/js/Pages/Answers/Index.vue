<template>

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
                            <a href="/answers" class="active" @click.prevent="form.get('/answers')" data-tab="maintab_2">
                                퀴즈 랭킹
                                <i class="xi-angle-down"></i>
                            </a>
                            <a href="#" class="" data-tab="maintab_3"  @click.prevent="form.get('/answers/questions')">
                                퀴즈 내역
                                <i class="xi-angle-down"></i>
                            </a>
                        </ul>

                        <div class="tab_content active" id="maintab_1">
                            <div class="khrank_top">
                                <!--                                <p class="guide">
                                                                    [기사완독 + 퀴즈 + 큐레이션을 통해 획득한 경험치 합산 랭킹입니다.]
                                                                </p>-->
                                <div class="search_wrap">
                                    <select name="" id="" v-model="form.year" @change="filter()">
                                        <option :value="year" v-for="year in years" :key="year">{{ year }}년</option>
                                    </select>
                                    <select name="" id="" v-model="form.month" @change="filter()">
                                        <option value="1">1월</option>
                                        <option value="2">2월</option>
                                        <option value="3">3월</option>
                                        <option value="4">4월</option>
                                        <option value="5">5월</option>
                                        <option value="6">6월</option>
                                        <option value="7">7월</option>
                                        <option value="8">8월</option>
                                        <option value="9">9월</option>
                                        <option value="10">10월</option>
                                        <option value="11">11월</option>
                                        <option value="12">12월</option>
                                    </select>
                                    <select name="" id="" v-model="form.duration" @change="filter()">
                                        <option value="일간">일간</option>
                                        <option value="주간">주간</option>
                                        <option value="월간">월간</option>
                                    </select>
                                    <div class="date_select">
                                        <input type="date" v-model="form.started_at">
                                        ~
                                        <input type="date" v-model="form.finished_at">
                                    </div>
                                </div>
                            </div>
                            <div class="khrank_area">
                                <table>
                                    <colgroup>
                                        <col width="20%">
                                        <col width="40%">
                                        <col width="40%">
                                    </colgroup>
                                    <thead>
                                    <tr>
                                        <th>순위</th>
                                        <th>ID</th>
                                        <th>포인트</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-if="items.data.length === 0">
                                        <td colspan="3" style="text-align: center">
                                            데이터가 없습니다.
                                        </td>
                                    </tr>
                                    <tr v-for="(item, index) in items.data" :key="item.id">
                                        <td>
                                            <p>
                                                {{index + 1}}
                                                <span class="fst_icon" v-if="index === 0">
                                                        <img src="/img/crown.png" alt="">
                                                    </span>
                                            </p>
                                        </td>
                                        <td>
                                            {{ item.user.name }}
                                        </td>
                                        <td>
                                            {{ item.total.toLocaleString() }}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
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

export default {
    components: {Link, Pagination},
    data(){
        return {
            items: this.$page.props.items,
            years: [],
            form: this.$inertia.form({
                page: 1,
                type: this.$page.props.type,
                started_at: this.$page.props.started_at,
                finished_at: this.$page.props.finished_at,
                category: this.$page.props.category,
                year: this.$page.props.year,
                month: this.$page.props.month,
                duration: this.$page.props.duration,
                khan_id: this.$page.props.khan_id
            })
        }
    },
    methods:{
        filter(){
            this.form.get("/answers", {
                preserveScroll: true,
                preserveState: false,
                onSuccess: (page) => {
                    this.items = page.props.items;
                }
            });
        },

        move(){

        }
    },

    mounted() {
        let date = new Date();

        let year = date.getFullYear();

        for(let i = year - 10; i <= year; i++){
            this.years.unshift(i);
        }
    }
}
</script>
