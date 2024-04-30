<template>
    <section class="p-8">
        <nav>
            <ul class="flex-row flex gap-3 font-bold">
                <li v-for="item in navigation" :key="item.displayName" @mouseover="() => handleMouseOver(item)" @mouseleave="handleMouseLeave">
                    <a class="underline" :href="item.url">{{ item.displayName }}</a>
                    <Transition name="fade">
                        <template v-if="showSubItems === item">
                            <ul class="item-with-subitems bg-slate-900 bg-opacity-25">
                                <li class="subitem" v-for="subItem in item.subItems" :key="subItem.displayName">
                                    <a :href="subItem.url">{{ subItem.displayName }}</a>
                                </li>
                            </ul>
                        </template>
                    </Transition>
                </li>
            </ul>
        </nav>
    </section>
</template>

<script setup>
import { ref } from 'vue';

const navigation = ref([
    {
        displayName: 'Home',
        url: '/'
    },
    {
        displayName: 'Kategorien',
        url: '/categories'
    },
    {
        displayName: 'Verkaufen',
        url: '/sell'
    },
    {
        displayName: 'Unternehmen',
        subItems: [
            {
                displayName: 'Philosophie',
                url: '/philosophy'
            },
            {
                displayName: 'Karriere',
                url: '/career'
            }
        ]
    }
]);

const showSubItems = ref(null); // Track the currently hovered parent item

function handleMouseLeave() {
    showSubItems.value = null;
}
function handleMouseOver(item) {
    showSubItems.value = item;
}
</script>

<style>
ul {
    padding-left: 1rem;
}

.item-with-subitems{
    position: absolute;
}

.subitem {
    opacity: 1; /* Initially hidden */
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

a:hover {
    color: white;
}
</style>
