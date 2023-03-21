<template>
    <div class="container mt-3">
        <h2>Crypto table</h2>
        <div class="p-2"></div>
        <form class="row g-3">
            <div class="col-auto">
                <input v-model="searchInput" class="form-control" id="ex24" type="text" placeholder="Enter crypto name">
            </div>
        </form>
        <div class="m-3" v-if="!laravelData.data.length">
            <div class="alert alert-danger" >
                Table "crypto" es empty or has no data. Please, execute "<span class="fw-bold">php artisan crypto:get-data</span>" command to fill table with data.
            </div>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th colspan="2">Name</th>
                <th>Price</th>
                <th>1h</th>
                <th>24h</th>
                <th>7d</th>
                <th>Market Cap</th>
                <th>Volume(24h)</th>
                <th>Circulating Supply</th>
                <th>Last 7 Days</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="post in laravelData.data" :key="post.id">
                <td>{{ post.id }}</td>
                <td><img style="width: 32px" :src="`/storage/logos/${post.crypto_id}.png`" loading="lazy" :alt="`${post.symbol} logo`"></td>
                <td>{{ post.name }} <span class="fw-light">{{ post.symbol }}</span></td>
                <td>{{ post.price }}</td>
                <td><span :class="[post.percent_change_1h >=0 ? 'text-success': 'text-danger']">{{ post.percent_change_1h }}</span></td>
                <td><span :class="[post.percent_change_24h >=0 ? 'text-success': 'text-danger']">{{ post.percent_change_24h }}</span></td>
                <td><span :class="[post.percent_change_7d >=0 ? 'text-success': 'text-danger']">{{ post.percent_change_7d }}</span></td>
                <td>{{ post.market_cap }}</td>
                <td>{{ post.volume_24h }}</td>
                <td>{{ post.circulating_supply }}</td>
                <td>
                    <span :style="[post.percent_change_7d >=0 ? green: red]">
                        <img :src="`/storage/sparklines/${post.crypto_id}.svg`" loading="lazy" :alt="`${post.symbol} sparkline`">
                    </span>
                </td>
            </tr>
            </tbody>
        </table>
        <div>
            <TailwindPagination
                :data="laravelData"
                @pagination-change-page="getResults"
            />
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, watch  } from 'vue';
import { TailwindPagination } from 'laravel-vue-pagination';

const green = 'filter: hue-rotate(85deg) saturate(80%) brightness(0.85)';
const red = 'filter: hue-rotate(300deg) saturate(210%) brightness(0.7) contrast(170%)';
const searchInput = ref('');
const laravelData = ref({});

watch(searchInput, (current, previous) => {
    getResults(1, current)
})
const getResults = async (page = 1, searchInput = '') => {
    const response = await fetch(`/api/get?page=` + page + '&search_title=' + searchInput);
    laravelData.value = await response.json();
}

getResults();
</script>
