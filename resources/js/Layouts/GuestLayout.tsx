import { Link } from "@inertiajs/react";
import SliderImage from "@/components/SliderImage";
import { ArrowLongLeftIcon } from "@heroicons/react/24/solid";
import { PropsWithChildren } from "react";
import { Toaster } from "@/components/ui/toaster";

export default function Guest({ children }: PropsWithChildren) {
    return (
        <main className="p-4 grid grid-cols-1 md:grid-cols-2 gap-4 h-screen">
            <section className=" justify-center items-center overflow-hidden relative hidden md:flex">
                <Link
                    href="/"
                    className="absolute top-8 left-8 z-30 backdrop-blur-md p-4 rounded-full flex bg-black/55 bg-opacity-50"
                >
                    <ArrowLongLeftIcon className="text-white w-6 me-2" />
                    <h1 className="text-white text-xl">Kembali Ke Home</h1>
                </Link>
                <SliderImage />
            </section>
            <section className="w-full md:flex md:justify-center md:items-center">
                <div>{children}</div>
            </section>
            <Toaster />
        </main>
    );
}
