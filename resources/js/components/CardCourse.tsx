import { cn } from "@/lib/utils";
import React, { ComponentPropsWithoutRef } from "react";
import { StarIcon } from "@heroicons/react/24/solid";

interface CardCourseProps extends ComponentPropsWithoutRef<"div"> {
    title: string;
    thumbnail: string;
    rate: number;
    applied: number;
    price: number;
    discount: number;
    category: string;
}

export const CardCourse: React.FC<CardCourseProps> = ({
    title,
    thumbnail,
    rate,
    applied,
    price,
    discount,
    category,
    className,
}) => {
    return (
        <div
            className={cn(
                "card flex flex-col gap-2 border rounded-[2rem] max-w-[26rem] h-full justify-between",
                className
            )}
        >
            <div className="flex flex-col gap-6">
                <div className="relative w-full">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        xmlnsXlink="http://www.w3.org/1999/xlink"
                        width="416"
                        height="278"
                        viewBox="0 0 416 278"
                        fill="none"
                    >
                        <path
                            d="M415.5 30C415.5 13.4315 402.069 0 385.5 0H30.5C13.9315 0 0.5 13.4315 0.5 30V248C0.5 264.569 13.9315 278 30.5 278H245C259.083 278 270.5 266.583 270.5 252.5C270.5 238.417 281.917 227 296 227H385.5C402.069 227 415.5 213.569 415.5 197V30Z"
                            fill="#C4C4C4"
                        />
                        <path
                            d="M415.5 30C415.5 13.4315 402.069 0 385.5 0H30.5C13.9315 0 0.5 13.4315 0.5 30V248C0.5 264.569 13.9315 278 30.5 278H245C259.083 278 270.5 266.583 270.5 252.5C270.5 238.417 281.917 227 296 227H385.5C402.069 227 415.5 213.569 415.5 197V30Z"
                            fill="url(#pattern0_126_628)"
                        />
                        <defs>
                            <pattern
                                id="pattern0_126_628"
                                patternContentUnits="userSpaceOnUse"
                                width="1"
                                height="1"
                                className="object-cover bg-no-repeat"
                            >
                                <image
                                    id="image0_126_628"
                                    className="object-cover w-full h-full "
                                    href={thumbnail}
                                />
                            </pattern>
                        </defs>
                    </svg>
                    <div className="rate-applied absolute top-3/4 translate-y-2/4 left-2/4 translate-x-3/4 flex gap-1 items-end px-1 py-2">
                        <div className="flex gap-2 items-center">
                            <StarIcon width={20} />
                            <h5 className="text-xl">{rate}</h5>
                        </div>
                        <h6 className="text-sm text-gray-500 mb-0.5">
                            ({applied})
                        </h6>
                    </div>
                </div>
                <div className="px-4">
                    <h2 className="text-2xl font-semibold">{title}</h2>
                    <p className="category py-1 text-gray-600 font-medium">
                        {category}
                    </p>
                </div>
            </div>

            <div className="px-4 flex gap-2 pb-6 justify-between margin-auto">
                <div>
                    <h6 className="text-2xl font-semibold">
                        IDR.{" "}
                        {Math.round(price) > 10000
                            ? Math.round(price)
                                  .toString()
                                  .replace(/0{3}$/, "") + "k"
                            : Math.round(price)}
                    </h6>
                </div>
                <div className="action">
                    <button className="bg-primary text-white px-4 py-2 rounded-lg">
                        Berlangganan
                    </button>
                </div>
            </div>
        </div>
    );
};
