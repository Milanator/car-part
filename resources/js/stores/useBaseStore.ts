import axios from 'axios';
import { defineStore } from 'pinia';

interface BaseEntity {
    id?: number;
}

export function defineBaseStore<Entity extends BaseEntity>(storeName: string) {
    return defineStore(storeName, {
        state: () => ({
            items: [] as Entity[],
        }),
        actions: {
            async fetchItems() {
                try {
                    const res = await axios.get<Entity[]>(`/api/${storeName}`);

                    this.items = res.data;
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
                    this.items.push(res.data);
                } catch (error) {
                    console.error(`Failed createItem:`, error);
                    throw error;
                }
            },

            async updateItem(id: number, item: Entity) {
                try {
                    const res = await axios.put<Entity>(`/api/${storeName}/${id}`, item);
                    const index = this.items.findIndex((i) => i.id === id);

                    if (index !== -1) this.items[index] = res.data;
                } catch (error) {
                    console.error(`Failed updateItem:`, error);
                    throw error;
                }
            },

            async deleteItem(id: number) {
                try {
                    await axios.delete(`/api/${storeName}/${id}`);
                    this.items = this.items.filter((i) => i.id !== id);
                } catch (error) {
                    console.error(`Failed deleteItem:`, error);
                    throw error;
                }
            },
        },
    });
}
