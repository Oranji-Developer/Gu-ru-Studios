import React from "react";
import { SimpleCard } from "@/components/SimpleCard";
import { whyGuruContent } from "@/lib/data/whyGuru";

export const Supperior = () => {
    return (
        <section className="" id="aboutUs">
            <div className="header mb-8">
                <h1 className="text-[3.5rem] font-semibold text-center">
                    Kenapa <span className="text-primary">Gu Ru Studios</span>?
                </h1>
            </div>
            <div className="grid grid-cols-12 gap-4">
                {whyGuruContent.map((content, index) => (
                    <SimpleCard
                        className={index % 3 != 0 ? "col-span-7" : "col-span-5"}
                        key={index}
                        title={content.title}
                        image={content.image}
                        desc={content.desc}
                    />
                ))}
            </div>
        </section>
    );
};
