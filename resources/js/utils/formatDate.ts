/**
 * Format date to French locale
 */
export const formatDate = (dateString: string): string => {
    return new Date(dateString).toLocaleDateString('fr-FR', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    })
}

