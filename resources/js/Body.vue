<template>
    <div class="flex justify-center">
            <div class="flex w-2/5">
                <p class="mt-8 p-1 dotted border-t-2 border-l-2 border-current w-1/2"> <button @click="countUp">Count up</button> {{ count }}</p>
                <p class="mt-8 p-1 pl-2 dotted border-b-2 border-r-2 border-current w-1/2"><button @click="addRandom">Random Number</button>  {{ random }} </p>
            </div>
    </div><div class="flex flex-grow ">
    <div class="basis-1/4"></div>
    <div class="basis-1/2 flex flex-col">
            <div id="app">
                <ArticleSearch />
            </div>
    </div>
    <div class="basis-1/4">
        <div class="mb-4 pl-4">
            <div class="overflow-y-auto h-64">
                <a class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded" href="/cart/show">Warenkorb
                    anzeigen</a>
            </div>
        </div>
    </div>
</div>
</template>

<script >
import ArticleSearch from "./ArticleSearch.vue";

export default {
    name: 'Body',
    components: {
        ArticleSearch
    },
    methods: {
        countUp() {
            this.count++;
        },
        addRandom() {
            this.random = Math.floor(Math.random() * 100);
        }
    },
    data() {
        return {
            count: 0,
            random: 0
        };
    }
}
</script>

