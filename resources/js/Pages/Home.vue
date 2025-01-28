<script setup>
    import BaseLayout from "@/Layouts/BaseLayout.vue";
    import { Link } from '@inertiajs/vue3'

    defineOptions({
        layout: BaseLayout,
    })

    defineProps({
        employees: Array,
        services: Array,
    });
</script>

<template>
    <div class="space-y-10">
        <div>
            <h2 class="text-xl font-medium">Choose a professional</h2>

            <div class="grid grid-col-2 md:grid-cols-5 gap-8 mt-6">
                <Link class="py-8 px-4 border border-slate-200 rounded-lg shadow-sm flex flex-col items-center justify-center text-center hover:bg-gray50/75"
                      v-for="(employee, index) in employees" :key="index">

                    <img :src="employee.profile_photo_url" class="rounded-full size-14" alt="">

                    <div>
                        {{ employee.name }}
                    </div>
                </Link>
            </div>
        </div>

        <div>
            <h2 class="text-xl font-medium">Or, Choose a service first</h2>

            <div class="grid grid-col-2 md:grid-cols-5 gap-8 mt-6">
                <Link class="py-8 px-4 border border-slate-200 rounded-lg shadow-sm flex flex-col items-center justify-center text-center hover:bg-gray50/75"
                      v-for="(service, index) in services" :key="index">

                    <div class="text-sm font-medium mt-3 text-slate-300">
                        {{ service.title }}
                    </div>

                    <div class="text-sm font-medium mt-1 text-slate-400">
                        {{ service.duration }} minutes
                    </div>

                    <div class="text-xs font-medium mt-3 text-slate-600 bg-slate-200 rounded-lg py-0.5 px-1.5">
                        {{ service.price }}
                    </div>
                </Link>
            </div>
        </div>

        <div></div>
    </div>
</template>

<style scoped>

</style>
