import { cn } from "@/lib/utils";
import React, { ComponentPropsWithoutRef } from "react";

interface SimpleCardProps extends ComponentPropsWithoutRef<"div"> {
    title: string;
    image: string;
    desc: string;
}

export const SimpleCard: React.FC<SimpleCardProps> = ({
    title,
    image,
    desc,
    className = "",
    ...props
}) => {
    return (
        <div
            {...props}
            className={cn(
                "card flex flex-col gap-6 border rounded-[1.25rem] p-6",
                className
            )}
        >
            <h1 className="text-4xl font-semibold">{title}</h1>
            <img
                src={image}
                alt=""
                className="h-[15.625rem] w-full object-cover rounded-lg"
            />
            <p className="text-2xl text-gray-500">{desc}</p>
        </div>
    );
};
