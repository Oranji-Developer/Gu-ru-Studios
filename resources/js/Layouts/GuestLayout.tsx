import ApplicationLogo from "@/components/ApplicationLogo";
import { Link } from "@inertiajs/react";
import SliderImage from "@/components/SliderImage";
import { ArrowLongLeftIcon } from "@heroicons/react/24/solid";
import { PropsWithChildren } from "react";

export default function Guest({ children }: PropsWithChildren) {
    return (
        <main className="p-4 grid grid-cols-2 gap-4 h-screen">
            <section className="flex justify-center items-center overflow-hidden relative">
                <Link
                    href="/"
                    className="absolute top-8 left-8 z-30 backdrop-blur-md p-4 rounded-full flex bg-black/55 bg-opacity-50"
                >
                    <ArrowLongLeftIcon className="text-white w-6 me-2" />
                    <h1 className="text-white text-xl">Kembali Ke Home</h1>
                </Link>
                <SliderImage />
            </section>
            <section className="flex justify-center items-center">
                <div>{children}</div>
            </section>
        </main>
    );
}
