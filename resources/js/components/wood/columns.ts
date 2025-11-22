// import { ColumnDef } from '@tanstack/vue-table';
import { h } from 'vue';

// interface Wood {
//     id: number;
//     public_id: string;
//     name: string;
//     description: string;
// }

export const columns: ColumnDef<Wood>[] = [
  {
    accessorKey: 'name',
    header: () => h('div', { class: 'text-right' }, 'Name'),
    cell: ({ row }) => {
      const name = Number.parseFloat(row.getValue('name'))
      const formatted = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
      }).format(name)

      return h('div', { class: 'text-right font-medium' }, formatted)
    },
  }
]
