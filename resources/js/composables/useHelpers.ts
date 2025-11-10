export function useCalculations() {
    // CBM calculation functions
    const calculateCBMLog = (length: number, diameter: number, list_cbm_log: any[]): number => {
        if (!length || !diameter || !list_cbm_log) return 0;

        for (const item of list_cbm_log) {
            if (item.length == length && item.diameter == diameter) {
                return Number(item.cbm) || 0;
            }
        }
        return 0;
    };

    const calculateCBMTimber = (length: number, width: number, thickness: number): number => {
        if (!length || !width || !thickness) return 0;
        const result = (length * width * thickness) / 1000000;

        return Number(result.toFixed(3));
    };

    return {
        calculateCBMLog, calculateCBMTimber,
    }
}

export function useFormatters() {
    // Formatting function
    const formatDate = (dateString: string | Date) => {
        if (!dateString) return '-';
        const date = new Date(dateString);

        return date.toLocaleDateString('id-ID', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }

    const formatRupiah = (amount: number): string => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(amount);
    }

    return {
        formatDate, formatRupiah,
    }
}

export function useStatus() {
    const getStatusText = (status: number) => {
        const statusMap: { [key: number]: string } = {
            0: 'Purchase Order',
            1: 'Purchased',
            2: 'Rejected',
            3: 'Sawmill',
            4: 'Sawn Stock',
            5: 'Vacuuming',
            6: 'Oven',
            7: 'Dry Stock',
            8: 'On Production',
            9: 'Completed',
        };

        return statusMap[status] || status;
    }

    return {
        getStatusText,
    }
}
