import { usePage } from "@inertiajs/react";
import React from "react";

export default function PaymentWhatshapp() {
    const page = usePage().props;
    console.log(page);
    return (
        <div>
            <h1>Payment Whatshapp</h1>
        </div>
    );
}
