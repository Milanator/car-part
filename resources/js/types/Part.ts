import { Car } from '@/types/Car';

export interface Part {
    id?: number;
    name: string;
    serial_number: string;
    car?: Car;
}
