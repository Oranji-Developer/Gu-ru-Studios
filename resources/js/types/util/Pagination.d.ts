export type Pagination = {
    current_page: number;
    first_page_url: string;
    last_page_url: string;
    links: {
        url: string;
        label: string;
        active: boolean;
    }[];
    from: number;
    to: number;
    total: number;
    per_page: number;
};
