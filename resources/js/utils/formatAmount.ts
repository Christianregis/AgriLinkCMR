/**
 * Format amount with French locale
 */
export const formatAmount = (amount: number): string => {
    return new Intl.NumberFormat('fr-FR').format(amount)
}
