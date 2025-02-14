"use client";

import { useState } from "react";
import { Star } from "lucide-react";

interface StarRatingProps {
    totalStars?: number;
    initialRating?: number;
    onRatingChange?: (rating: number) => void;
    readOnly?: boolean;
}

export function StarRating({
    totalStars = 5,
    initialRating = 0,
    onRatingChange,
    readOnly = false,
}: StarRatingProps) {
    const [rating, setRating] = useState(initialRating);
    const [hover, setHover] = useState(0);

    const handleClick = (index: number) => {
        if (!readOnly) {
            setRating(index);
            if (onRatingChange) {
                onRatingChange(index);
            }
        }
    };

    const handleMouseEnter = (index: number) => {
        if (!readOnly) {
            setHover(index);
        }
    };

    const handleMouseLeave = () => {
        if (!readOnly) {
            setHover(0);
        }
    };

    return (
        <div className="flex">
            {[...Array(totalStars)].map((_, index) => {
                index += 1;
                return (
                    <button
                        type="button"
                        key={index}
                        className={`${
                            index <= (hover || rating)
                                ? "text-yellow-400"
                                : "text-gray-300"
                        } ${readOnly ? "cursor-default" : "cursor-pointer"}`}
                        onClick={() => handleClick(index)}
                        onMouseEnter={() => handleMouseEnter(index)}
                        onMouseLeave={handleMouseLeave}
                        disabled={readOnly}
                    >
                        <Star
                            className={`h-6 w-6 ${
                                index <= (hover || rating) ? "fill-current" : ""
                            }`}
                        />
                    </button>
                );
            })}
        </div>
    );
}
