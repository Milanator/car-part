import { Part } from '@/types/Part';

export interface Car {
    id?: number;
    name: string;
    registration_number: string;
    is_registered: boolean;
    is_registered_text?: string;
    parts: Array<Part>;
}
