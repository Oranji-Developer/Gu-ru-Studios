import { usePage, Link } from "@inertiajs/react";
import React from "react";
import { Button } from "@/components/ui/button";

export default function PaymentWhatshapp() {
    const page = usePage().props;
    console.log(page);
    return (
        <main className="flex justify-center items-center h-screen px-10">
            <div className="flex flex-col gap-6 items-center w-4/6 text-center justify-center h-full">
                <h1 className="text-4xl font-medium">
                    Pembayaran hanya melalui WhatsApp. Pastikan transaksi hanya
                    di nomor resmi kami! 🚨
                </h1>
                <a href="https://wa.me/+6281234567890">
                    <Button type="button" size={"xl"}>
                        Lanjut WhatsApp yuk
                    </Button>
                </a>

                <p className="text-gray-500 font-medium w-4/6">
                    Jika Anda memiliki masalah, jangan ragu untuk menghubungi
                    kami di{" "}
                    <span className="text-primary">[support@example.com]</span>{" "}
                    atau
                    <span className="text-primary"> wa.me/62812345678.</span>
                </p>
            </div>
        </main>
    );
}
