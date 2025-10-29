export interface InputProps {
    id: string;
    label: string;
    modelValue: string | number | undefined;
    type?: string;
    required?: boolean;
    readonly?: boolean;
}
