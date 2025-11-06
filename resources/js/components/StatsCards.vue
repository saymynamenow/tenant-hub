<template>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <StatCard
            icon="package"
            label="Total Products"
            :value="stats.totalProducts"
            color="blue"
        />
        <StatCard
            icon="check-circle"
            label="In Stock"
            :value="stats.inStock"
            color="green"
        />
        <StatCard
            icon="alert-circle"
            label="Out of Stock"
            :value="stats.outOfStock"
            color="red"
        />
        <StatCard
            icon="dollar-sign"
            label="Total Value"
            :value="`$${stats.totalValue}`"
            color="purple"
        />
    </div>
</template>

<script>
import StatCard from "./StatCard.vue";

export default {
    name: "StatsCards",
    components: {
        StatCard,
    },
    props: {
        stats: {
            type: Object,
            required: true,
        },
    },
};
</script>
