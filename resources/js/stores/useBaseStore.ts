import { useFlashMessageStore } from '@/stores/useFlashMessageStore';
import axios from 'axios';
import { defineStore } from 'pinia';

interface BaseEntity {
    id?: number;
}

export function defineBaseStore<Entity extends BaseEntity>(storeName: string) {
    return defineStore(storeName, {
        state: () => ({
            items: [] as Entity[],
            filterable: []
        }),
        actions: {
            async fetchItems(params = {}) {
                try {
                    const res = await axios.get<Entity[]>(`/api/${storeName}`, { params });

                    this.filterable = res.data.filterable
                    this.items = res.data.items;
                } catch (error) {
                    console.error(`Failed fetchItems:`, error);
                    throw error;
                }
            },

            async getItem(id: number): Promise<Entity> {
                try {
                    const res = await axios.get<Entity>(`/api/${storeName}/${id}`);
                    return res.data;
                } catch (error) {
                    console.error(`Failed getItem:`, error);
                    throw error;
                }
            },

            async createItem(item: Entity) {
                try {
                    const res = await axios.post<Entity>(`/api/${storeName}`, item);

                    useFlashMessageStore().success(res.data.message);

                    return res.data;
                } catch (error) {
                    useFlashMessageStore().error(error);
                    throw error;
                }
            },

            async updateItem(id: number, item: Entity) {
                try {
                    const res = await axios.put<Entity>(`/api/${storeName}/${id}`, item);

                    useFlashMessageStore().success(res.data.message);

                    return res.data;
                } catch (error) {
                    useFlashMessageStore().error(error);
                    throw error;
                }
            },

            async deleteItem(id: number) {
                try {
                    const res = await axios.delete(`/api/${storeName}/${id}`);

                    this.items = this.items.filter((i) => i.id !== id);

                    useFlashMessageStore().success(res.data.message);

                    return res.data;
                } catch (error) {
                    useFlashMessageStore().error(error);
                    throw error;
                }
            },
        },
    });
}
