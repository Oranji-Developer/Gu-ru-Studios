"use client";

import * as React from "react";
import { cn } from "@/lib/utils";
import { Button } from "@/components/ui/button";
import { ScrollArea, ScrollBar } from "@/components/ui/scroll-area";

export function TimePicker({
    data,
    setData,
}: {
    data: Date;
    setData: (data: Date) => void;
}) {
    const hours = Array.from({ length: 24 }, (_, i) => i);

    const [date, setDate] = React.useState<Date | null>(new Date(data));

    const handleTimeChange = (type: "hour" | "minute", value: string) => {
        if (date) {
            const newDate = new Date(date);
            if (type === "hour") {
                newDate.setHours(parseInt(value));
            } else if (type === "minute") {
                newDate.setMinutes(parseInt(value));
            }
            setData(newDate);
            setDate(newDate);
        }
    };

    return (
        <div className="sm:flex flex-col gap-4 justify-center items-center p-4 py-2">
            <div className="flex">
                <h1 className="text-4xl font-bold">
                    {date?.getHours()}
                    <span className="mx-1">:</span>
                    {date
                        ? date.getMinutes() < 10
                            ? "0" + date.getMinutes()
                            : date.getMinutes()
                        : "00"}
                </h1>
            </div>
            <div className="flex flex-col sm:flex-row sm:h-[150px] divide-y sm:divide-y-0 sm:divide-x">
                <ScrollArea className="w-64 sm:w-auto">
                    <div className="flex sm:flex-col p-2">
                        {hours.reverse().map((hour) => (
                            <Button
                                key={hour}
                                size="icon"
                                variant={
                                    date && date.getHours() === hour
                                        ? "default"
                                        : "ghost"
                                }
                                className="sm:w-full shrink-0 aspect-square"
                                onClick={() =>
                                    handleTimeChange("hour", hour.toString())
                                }
                            >
                                {hour}
                            </Button>
                        ))}
                    </div>
                    <ScrollBar orientation="horizontal" className="sm:hidden" />
                </ScrollArea>
                <ScrollArea className="w-64 sm:w-auto">
                    <div className="flex sm:flex-col p-2">
                        {Array.from({ length: 12 }, (_, i) => i * 5).map(
                            (minute) => (
                                <Button
                                    key={minute}
                                    size="icon"
                                    variant={
                                        date && date.getMinutes() === minute
                                            ? "default"
                                            : "ghost"
                                    }
                                    className="sm:w-full shrink-0 aspect-square"
                                    onClick={() =>
                                        handleTimeChange(
                                            "minute",
                                            minute.toString()
                                        )
                                    }
                                >
                                    {minute.toString().padStart(2, "0")}
                                </Button>
                            )
                        )}
                    </div>
                    <ScrollBar orientation="horizontal" className="sm:hidden" />
                </ScrollArea>
            </div>
        </div>
    );
}
