<template>
    <div class="flex">
        <div class="grid justify-center basis-1/4">
            <p class="mt-8 p-1 dotted border-t-2 border-l-2 border-current w-1/2"> <button @click="countUp">Count up</button> {{ count }}</p>
            <p class="mt-8 p-1 pl-2 dotted border-b-2 border-r-2 border-current w-1/2"><button @click="addRandom">Random Number</button>  {{ random }} </p>
        </div>
        <div class="basis-3/4"></div>
    </div>
</template>

<script >
export default {
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

