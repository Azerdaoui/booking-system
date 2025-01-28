<script setup>
    import BaseLayout from "@/Layouts/BaseLayout.vue";
    import { Link } from '@inertiajs/vue3'
    import Service from "@/Components/Service.vue";

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
                <Link :href="route('employee', employee)" class="py-8 px-4 border border-slate-200 rounded-lg shadow-sm flex flex-col items-center justify-center text-center hover:bg-gray50/75"
                      v-for="employee in employees" :key="employee.id">

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
                <Service v-for="(service, index) in services" :key="index" :service="service" />
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
