<template>
  <main class="bg-neutral-bg flex min-h-screen antialiased">
    <!-- SIDEBAR -->
    <aside
      class="hidden lg:flex flex-col w-72 bg-white border-r border-gray-100 sticky top-0 h-screen z-40"
    >
      <div class="p-8 border-b border-gray-50">
        <div class="flex items-center space-x-2">
          <div class="bg-brand-primary p-2 rounded-lg">
            <i class="fas fa-leaf text-white text-xl"></i>
          </div>
          <span class="text-2xl font-bold text-brand-dark tracking-tight"
            >AgriLink<span class="text-brand-primary">.cm</span></span
          >
        </div>
      </div>

      <nav class="flex-1 p-6 space-y-2">
        <div
          class="text-[10px] font-bold uppercase tracking-widest text-neutral-muted mb-4 px-4"
        >
          Menu Principal
        </div>
        <a
          href="#"
          class="flex items-center space-x-3 px-4 py-3 rounded-xl sidebar-active"
        >
          <i class="fas fa-chart-line w-5 text-center"></i>
          <span class="font-semibold">Vue d'ensemble</span>
        </a>
        <a
          href="#"
          class="flex items-center space-x-3 px-4 py-3 rounded-xl text-neutral-body hover:bg-brand-bg hover:text-brand-primary transition-all group"
        >
          <i
            class="fas fa-box w-5 text-center text-neutral-muted group-hover:text-brand-primary"
          ></i>
          <span class="font-medium">Mes Produits</span>
        </a>
        <a
          href="#"
          class="flex items-center space-x-3 px-4 py-3 rounded-xl text-neutral-body hover:bg-brand-bg hover:text-brand-primary transition-all group"
        >
          <i
            class="fas fa-receipt w-5 text-center text-neutral-muted group-hover:text-brand-primary"
          ></i>
          <span class="font-medium">Commandes</span>
          <span
            class="ml-auto bg-accent-cta text-white text-[10px] px-2 py-0.5 rounded-full"
            >4</span
          >
        </a>
        <a
          href="#"
          class="flex items-center space-x-3 px-4 py-3 rounded-xl text-neutral-body hover:bg-brand-bg hover:text-brand-primary transition-all group"
        >
          <i
            class="fas fa-comment-dots w-5 text-center text-neutral-muted group-hover:text-brand-primary"
          ></i>
          <span class="font-medium">Messages</span>
          <span
            class="ml-auto bg-brand-primary text-white text-[10px] px-2 py-0.5 rounded-full"
            >2</span
          >
        </a>
        <a
          href="#"
          class="flex items-center space-x-3 px-4 py-3 rounded-xl text-neutral-body hover:bg-brand-bg hover:text-brand-primary transition-all group"
        >
          <i
            class="fas fa-star w-5 text-center text-neutral-muted group-hover:text-brand-primary"
          ></i>
          <span class="font-medium">Avis Clients</span>
        </a>

        <div
          class="pt-8 text-[10px] font-bold uppercase tracking-widest text-neutral-muted mb-4 px-4"
        >
          Mon Compte
        </div>
        <a
          href="#"
          class="flex items-center space-x-3 px-4 py-3 rounded-xl text-neutral-body hover:bg-brand-bg hover:text-brand-primary transition-all group"
        >
          <i
            class="fas fa-user-circle w-5 text-center text-neutral-muted group-hover:text-brand-primary"
          ></i>
          <span class="font-medium">Profil Ferme</span>
        </a>
        <a
          href="#"
          class="flex items-center space-x-3 px-4 py-3 rounded-xl text-neutral-body hover:bg-brand-bg hover:text-brand-primary transition-all group"
        >
          <i
            class="fas fa-cog w-5 text-center text-neutral-muted group-hover:text-brand-primary"
          ></i>
          <span class="font-medium">Paramètres</span>
        </a>
      </nav>

      <div class="p-6 border-t border-gray-50">
        <button
          class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-red-500 hover:bg-red-50 transition-all font-semibold"
        >
          <i class="fas fa-sign-out-alt w-5 text-center"></i> <span>Déconnexion</span>
        </button>
      </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
      <!-- HEADER -->
      <header
        class="h-20 glass-header border-b border-gray-100 flex items-center justify-between px-8 sticky top-0 z-30"
      >
        <div class="flex items-center">
          <button class="lg:hidden text-neutral-body mr-4">
            <i class="fas fa-bars text-xl"></i>
          </button>
          <h1 class="text-xl font-bold text-neutral-title">
            Tableau de Bord Agriculteur
          </h1>
        </div>

        <div class="flex items-center space-x-6">
          <button
            class="relative w-10 h-10 flex items-center justify-center rounded-xl bg-gray-50 text-neutral-muted hover:text-brand-primary transition-colors"
          >
            <i class="far fa-bell text-lg"></i>
            <span
              class="absolute top-2.5 right-2.5 w-2 h-2 bg-red-500 rounded-full border-2 border-white"
            ></span>
          </button>
          <div class="flex items-center space-x-3 pl-6 border-l border-gray-100">
            <div class="text-right hidden sm:block">
              <p class="text-sm font-bold text-neutral-title">Ferme de Penja</p>
              <p
                class="text-[10px] font-bold text-brand-primary uppercase tracking-wider"
              >
                Producteur Certifié
              </p>
            </div>
            <img
              src="https://ui-avatars.com/api/?name=Ferme+Penja&background=2D6A4F&color=fff"
              class="w-11 h-11 rounded-xl shadow-sm border border-gray-100"
            />
          </div>
        </div>
      </header>

      <!-- DASHBOARD CONTENT -->
      <div class="flex-1 overflow-y-auto p-8 space-y-8">
        <!-- TOP STATS -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <div
            class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4"
          >
            <div
              class="w-14 h-14 bg-brand-bg text-brand-primary rounded-2xl flex items-center justify-center text-2xl"
            >
              <i class="fas fa-seedling"></i>
            </div>
            <div>
              <p class="text-xs font-bold text-neutral-muted uppercase tracking-wider">
                Produits Actifs
              </p>
              <h3 class="text-2xl font-bold text-neutral-title">24</h3>
            </div>
          </div>
          <div
            class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4"
          >
            <div
              class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl"
            >
              <i class="fas fa-shopping-basket"></i>
            </div>
            <div>
              <p class="text-xs font-bold text-neutral-muted uppercase tracking-wider">
                Commandes en cours
              </p>
              <h3 class="text-2xl font-bold text-neutral-title">08</h3>
            </div>
          </div>
          <div
            class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4"
          >
            <div
              class="w-14 h-14 bg-accent-light text-accent-cta rounded-2xl flex items-center justify-center text-2xl"
            >
              <i class="fas fa-wallet"></i>
            </div>
            <div>
              <p class="text-xs font-bold text-neutral-muted uppercase tracking-wider">
                C.A. du Mois
              </p>
              <h3 class="text-2xl font-bold text-neutral-title">
                185k <small class="text-xs">FCFA</small>
              </h3>
            </div>
          </div>
          <div
            class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4"
          >
            <div
              class="w-14 h-14 bg-orange-50 text-accent-star rounded-2xl flex items-center justify-center text-2xl"
            >
              <i class="fas fa-star"></i>
            </div>
            <div>
              <p class="text-xs font-bold text-neutral-muted uppercase tracking-wider">
                Note Moyenne
              </p>
              <h3 class="text-2xl font-bold text-neutral-title">
                4.8 <small class="text-xs text-neutral-muted">/ 5</small>
              </h3>
            </div>
          </div>
        </div>

        <!-- CHARTS & NOTIFICATIONS -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
          <!-- Sales Chart -->
          <div
            class="xl:col-span-2 bg-white p-8 rounded-2xl shadow-sm border border-gray-100"
          >
            <div class="flex items-center justify-between mb-8">
              <div>
                <h3 class="text-lg font-bold text-neutral-title">Évolution des Ventes</h3>
                <p class="text-sm text-neutral-muted italic">
                  Nombre de commandes et revenus (30 derniers jours)
                </p>
              </div>
              <select
                class="bg-neutral-bg border-none rounded-lg px-4 py-2 text-xs font-bold text-neutral-body focus:ring-0 cursor-pointer"
              >
                <option>30 derniers jours</option>
                <option>7 derniers jours</option>
              </select>
            </div>
            <div class="h-75 w-full">
              <canvas ref="chartRef"></canvas>
            </div>
          </div>

          <!-- Low Stock & Messages -->
          <div class="space-y-8">
            <!-- Low Stock -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
              <h3
                class="text-md font-bold text-neutral-title mb-4 flex items-center gap-2"
              >
                <i class="fas fa-exclamation-triangle text-red-500"></i> Alertes Stock
                Faible
              </h3>
              <div class="space-y-4">
                <div
                  class="flex items-center justify-between p-3 bg-red-50 rounded-xl border border-red-100"
                >
                  <div class="flex items-center gap-3">
                    <div
                      class="w-10 h-10 bg-white rounded-lg flex items-center justify-center text-red-500 font-bold shadow-sm text-xs"
                    >
                      Tom.
                    </div>
                    <div>
                      <p class="text-sm font-bold text-neutral-title">Tomates Cerises</p>
                      <p class="text-[10px] text-red-600 font-bold">Reste : 2 kg</p>
                    </div>
                  </div>
                  <button class="text-brand-primary hover:underline text-xs font-bold">
                    Réappro.
                  </button>
                </div>
                <div
                  class="flex items-center justify-between p-3 bg-orange-50 rounded-xl border border-orange-100"
                >
                  <div class="flex items-center gap-3">
                    <div
                      class="w-10 h-10 bg-white rounded-lg flex items-center justify-center text-orange-500 font-bold shadow-sm text-xs"
                    >
                      Anan.
                    </div>
                    <div>
                      <p class="text-sm font-bold text-neutral-title">Ananas Victoria</p>
                      <p class="text-[10px] text-orange-600 font-bold">
                        Reste : 5 unités
                      </p>
                    </div>
                  </div>
                  <button class="text-brand-primary hover:underline text-xs font-bold">
                    Réappro.
                  </button>
                </div>
              </div>
            </div>

            <!-- Recent Messages -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
              <div class="flex items-center justify-between mb-4">
                <h3 class="text-md font-bold text-neutral-title">Derniers Messages</h3>
                <span
                  class="bg-brand-primary text-white text-[10px] px-2 py-0.5 rounded-full font-bold"
                  >2 Nouveaux</span
                >
              </div>
              <div class="space-y-4">
                <div
                  class="flex items-start gap-3 p-2 hover:bg-neutral-bg rounded-xl transition-colors cursor-pointer"
                >
                  <img
                    src="https://ui-avatars.com/api/?name=Samuel+E&background=random"
                    class="w-10 h-10 rounded-lg"
                  />
                  <div class="flex-1 min-w-0">
                    <div class="flex justify-between">
                      <p class="text-xs font-bold text-neutral-title truncate">
                        Samuel Eto'o
                      </p>
                      <span class="text-[9px] text-neutral-muted">14:20</span>
                    </div>
                    <p class="text-[11px] text-neutral-muted truncate">
                      Bonjour, est-ce que le poivre de Penja est disponible en gros ?
                    </p>
                  </div>
                </div>
                <div
                  class="flex items-start gap-3 p-2 hover:bg-neutral-bg rounded-xl transition-colors cursor-pointer"
                >
                  <img
                    src="https://ui-avatars.com/api/?name=Marie+C&background=random"
                    class="w-10 h-10 rounded-lg"
                  />
                  <div class="flex-1 min-w-0">
                    <div class="flex justify-between">
                      <p class="text-xs font-bold text-neutral-title truncate">
                        Marie Claire
                      </p>
                      <span class="text-[9px] text-neutral-muted">Hier</span>
                    </div>
                    <p class="text-[11px] text-neutral-muted truncate">
                      Merci pour la livraison, les tomates sont superbes !
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- RECENT ORDERS TABLE -->
        <div
          class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden"
        >
          <div class="p-6 border-b border-gray-50 flex justify-between items-center">
            <h3 class="text-lg font-bold text-neutral-title">
              Dernières Commandes Reçues
            </h3>
            <button
              class="px-4 py-2 bg-brand-bg text-brand-primary rounded-lg text-xs font-bold hover:bg-brand-primary hover:text-white transition-all"
            >
              Voir tout l'historique
            </button>
          </div>
          <div class="overflow-x-auto">
            <table class="w-full text-left">
              <thead
                class="bg-neutral-bg/50 text-neutral-muted text-[10px] uppercase font-bold tracking-widest"
              >
                <tr>
                  <th class="px-8 py-4">ID Commande</th>
                  <th class="px-6 py-4">Client</th>
                  <th class="px-6 py-4">Produits</th>
                  <th class="px-6 py-4">Montant</th>
                  <th class="px-6 py-4">Statut</th>
                  <th class="px-8 py-4 text-right">Action</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-50">
                <tr class="hover:bg-neutral-bg/30 transition-colors">
                  <td class="px-8 py-5 font-bold text-neutral-title">#AGL-2026-00452</td>
                  <td class="px-6 py-5">
                    <div class="flex items-center gap-2">
                      <img
                        src="https://ui-avatars.com/api/?name=Jean+M&background=random"
                        class="w-7 h-7 rounded-full"
                      />
                      <span class="text-sm font-medium text-neutral-body">Jean Marc</span>
                    </div>
                  </td>
                  <td class="px-6 py-5 text-sm text-neutral-muted">
                    Poivre (2kg), Tomates (5kg)
                  </td>
                  <td class="px-6 py-5 font-bold text-brand-dark text-sm">14,500 FCFA</td>
                  <td class="px-6 py-5">
                    <span
                      class="px-3 py-1 bg-blue-100 text-blue-700 text-[10px] font-bold rounded-full uppercase"
                      >En cours</span
                    >
                  </td>
                  <td class="px-8 py-5 text-right">
                    <button
                      class="p-2 text-brand-primary hover:bg-brand-bg rounded-lg transition-all"
                    >
                      <i class="fas fa-eye"></i>
                    </button>
                    <button
                      class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-all ml-2"
                    >
                      <i class="fas fa-check"></i>
                    </button>
                  </td>
                </tr>
                <tr class="hover:bg-neutral-bg/30 transition-colors">
                  <td class="px-8 py-5 font-bold text-neutral-title">#AGL-2026-00448</td>
                  <td class="px-6 py-5">
                    <div class="flex items-center gap-2">
                      <img
                        src="https://ui-avatars.com/api/?name=Alice+B&background=random"
                        class="w-7 h-7 rounded-full"
                      />
                      <span class="text-sm font-medium text-neutral-body"
                        >Alice Bella</span
                      >
                    </div>
                  </td>
                  <td class="px-6 py-5 text-sm text-neutral-muted">
                    Régime Bananes (x2)
                  </td>
                  <td class="px-6 py-5 font-bold text-brand-dark text-sm">5,000 FCFA</td>
                  <td class="px-6 py-5">
                    <span
                      class="px-3 py-1 bg-yellow-100 text-yellow-700 text-[10px] font-bold rounded-full uppercase"
                      >Attente Paiement</span
                    >
                  </td>
                  <td class="px-8 py-5 text-right">
                    <button
                      class="p-2 text-brand-primary hover:bg-brand-bg rounded-lg transition-all"
                    >
                      <i class="fas fa-eye"></i>
                    </button>
                  </td>
                </tr>
                <tr class="hover:bg-neutral-bg/30 transition-colors">
                  <td class="px-8 py-5 font-bold text-neutral-title">#AGL-2026-00435</td>
                  <td class="px-6 py-5">
                    <div class="flex items-center gap-2">
                      <img
                        src="https://ui-avatars.com/api/?name=Resto+Yaounde&background=random"
                        class="w-7 h-7 rounded-full"
                      />
                      <span class="text-sm font-medium text-neutral-body"
                        >Le Gourmet Yaoundé</span
                      >
                    </div>
                  </td>
                  <td class="px-6 py-5 text-sm text-neutral-muted">Panier Mixte (x5)</td>
                  <td class="px-6 py-5 font-bold text-brand-dark text-sm">45,000 FCFA</td>
                  <td class="px-6 py-5">
                    <span
                      class="px-3 py-1 bg-green-100 text-green-700 text-[10px] font-bold rounded-full uppercase"
                      >Terminée</span
                    >
                  </td>
                  <td class="px-8 py-5 text-right">
                    <button
                      class="p-2 text-brand-primary hover:bg-brand-bg rounded-lg transition-all"
                    >
                      <i class="fas fa-eye"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>
  </main>
</template>
<script lang="ts" setup>
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
} from 'chart.js/auto';
import { onMounted, ref } from "vue";
import type { Auth } from "@/types";

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
);

const chartRef = ref<HTMLCanvasElement | null>(null);

onMounted(() => {
  if (!chartRef.value) {
    return;
  }

  const ctx = chartRef.value.getContext("2d");

  if (ctx) {
    return new Chart(ctx, {
      type: "line",
      data: {
        labels: ["1 Avr", "5 Avr", "10 Avr", "15 Avr", "20 Avr", "25 Avr", "30 Avr"],
        datasets: [
          {
            label: "Revenus (FCFA)",
            data: [12000, 45000, 28000, 65000, 42000, 85000, 185000],
            borderColor: "#2D6A4F",
            backgroundColor: "rgba(45, 106, 79, 0.1)",
            borderWidth: 3,
            tension: 0.4,
            fill: true,
            pointBackgroundColor: "#2D6A4F",
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false },
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: (value: number | string) => {
                return value.toString() + " FCFA";
              },
            },
          },
        },
      },
    });
  }
});
const props = defineProps<Auth>();
</script>
