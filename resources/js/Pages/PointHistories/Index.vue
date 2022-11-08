<template>
    <div class="container sub">

        <!-- 현재 위치 -->
<!--        <div class="breadcrumb">
            <span><a href="https://www.khan.co.kr" title="경향신문">경향신문</a></span>
            <span>
					<a href="kh_ranking.html" title="랭킹">
                        <strong>랭킹</strong>
                    </a>
				</span>
        </div>-->
        <!-- // 현재 위치 -->


        <!-- section -->
        <div class="section">
            <!-- inner -->
            <div class="inner">
                <!-- cont-main -->
                <div class="cont-main">
                    <div class="title-wrap">
                        <h3 class="sct_tit"> 랭킹 </h3>
                    </div>

                    <!-- ** 랭킹 콘텐츠 ** -->
                    <div class="khrank mainarea">
                        <ul class="maintab">
                            <li :class="form.type == '' ? 'active' : ''" data-tab="maintab_1" @click="form.type = ''; filter();">
                                전체
                                <i class="xi-angle-down"></i>
                            </li>
                            <li :class="form.type == '기사완독' ? 'active' : ''" data-tab="maintab_2" @click="form.type = '기사완독'; filter();">
                                기사
                                <i class="xi-angle-down"></i>
                            </li>
                            <li :class="form.type == '퀴즈정답' ? 'active' : ''" data-tab="maintab_3" @click="form.type = '퀴즈정답'; filter();">
                                퀴즈
                                <i class="xi-angle-down"></i>
                            </li>
                            <li :class="form.type == '큐레이션공유' ? 'active' : ''" data-tab="maintab_4" @click="form.type = '큐레이션공유'; filter();">
                                큐레이션
                                <i class="xi-angle-down"></i>
                            </li>
                        </ul>

                        <div class="tab_content active" id="maintab_1">
                            <div class="khrank_top">
                                <p class="guide" style="margin-bottom:20px; text-align:left; font-size:15px; font-weight:500;" v-if="form.type == ''">
                                    [기사완독 + 퀴즈 + 큐레이션을 통해 획득한 경험치 합산 랭킹입니다.]
                                </p>
                                <p class="guide" style="margin-bottom:20px; text-align:left; font-size:15px; font-weight:500;" v-if="form.type == '기사완독'">
                                    [기사완독을 통해 획득한 경험치 합산 랭킹입니다.]
                                </p>
                                <p class="guide" style="margin-bottom:20px; text-align:left; font-size:15px; font-weight:500;" v-if="form.type == '퀴즈정답'">
                                    [퀴즈를 통해 획득한 경험치 합산 랭킹입니다.]
                                </p>
                                <p class="guide" style="margin-bottom:20px; text-align:left; font-size:15px; font-weight:500;" v-if="form.type == '큐레이션공유'">
                                    [큐레이션을 통해 획득한 경험치 합산 랭킹입니다.]
                                </p>

                                <div class="box-categories type01" v-if="form.type == '기사완독'">
                                    <h3 class="title">
                                        분야별 랭킹

                                        <img src="/img/arrowRight-black.png" alt="">
                                    </h3>

                                    <div class="categories">
                                        <div class="category-wrap" @click="form.category = '';  filter()">
                                            <div :class="`category ${form.category == '' ? 'active' : ''} `">종합</div>
                                        </div>

                                        <div class="category-wrap" v-for="category in categories.data" :key="category.id" @click="form.category = category.code; filter()">
                                            <div :class="`category ${form.category == category.code  ? 'active' : ''}`">{{ category.title }}</div>
                                        </div>

                                    </div>
                                </div>

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
                    <!-- ** //랭킹 콘텐츠 ** -->

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
            categories: this.$page.props.categories,
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
            })
        }
    },
    methods:{
        filter(){
            this.form.get("/pointHistories", {
                preserveScroll: true,
                preserveState: false,
                onSuccess: (page) => {
                    this.items = page.props.items;
                }
            });
        },
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
