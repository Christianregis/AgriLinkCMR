<template>
    <div class="h-75 w-full">
        <canvas ref="chartRef"></canvas>
    </div>
</template>
<script setup lang="ts">
import {
    Chart,
    LineController,
    LineElement,
    PointElement,
    LinearScale,
    CategoryScale,
    Filler,
    Tooltip,
    Legend,
    Title,
} from 'chart.js/auto'
import { ref, onMounted, watch } from 'vue'

import { formatAmount } from '@/utils/formatAmount'

/**
 * Types et interfaces
 */
interface RevenueChartData {
    labels: string[]
    data: number[]
}

interface Props {
    chartData: RevenueChartData
}

/**
 * Enregistrement des composants Chart.js
 */
Chart.register(
    LineController,
    LineElement,
    PointElement,
    LinearScale,
    CategoryScale,
    Filler,
    Tooltip,
    Legend,
    Title
)

/**
 * Props definition
 */
const props = defineProps<Props>()

/**
 * Refs
 */
const chartRef = ref<HTMLCanvasElement | null>(null)
let chartInstance: Chart | null = null

/**
 * Initialize chart
 */
const initChart = (): void => {
    if (!chartRef.value) {
        return
    }

    // Détruire le graphique existant s\'il y en a un
    if (chartInstance) {
        chartInstance.destroy()
    }

    const ctx = chartRef.value.getContext('2d')

    if (ctx) {
        chartInstance = new Chart(ctx, {
            type: 'line',
            data: {
                labels: props.chartData.labels,
                datasets: [
                    {
                        label: 'Revenus (FCFA)',
                        data: props.chartData.data,
                        borderColor: '#2D6A4F',
                        backgroundColor: 'rgba(45, 106, 79, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#2D6A4F',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14,
                            weight: 'bold',
                        },
                        bodyFont: {
                            size: 13,
                        },
                        callbacks: {
                            label: (context: any) => {
                                const value = context.parsed.y

                                return `Revenus: ${formatAmount(value)} FCFA`
                            },
                        },
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: (value: string | number) => {
                                if (typeof value === 'number') {
                                    return new Intl.NumberFormat('fr-FR').format(value) + ' FCFA'
                                }

                                return value
                            },
                            font: {
                                size: 12,
                            },
                            color: '#9CA3AF',
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05),',
                        },
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 12,
                            },
                            color: '#9CA3AF',
                        },
                        grid: {
                            display: false,
                        },
                    },
                },
            },
        })
    }
}

/**
 * Si les proprietes du graphique changes, on reinitialise le graphique
 */
watch(
    () => props.chartData,
    () => {
        initChart()
    },
    { deep: true }
)

/**
 * Initialisation du graphique au montage du composant
 */
onMounted(() => {
    initChart()
})
</script>

<style scoped>
.h-75 {
    height: 300px;
}
</style>
