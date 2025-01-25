import { z } from "zod";

export function handlingZodInputError(
    zoderrors: z.SafeParseError<any>,
    errors: Partial<Record<string | number | symbol, string>>
) {
    for (const issue of zoderrors.error.issues) {
        if (
            errors[issue.path[0] as keyof typeof errors] === undefined ||
            errors[issue.path[0] as keyof typeof errors] === issue.message
        ) {
            errors[issue.path[0] as keyof typeof errors] = issue.message;
        } else {
            errors[issue.path[0] as keyof typeof errors] +=
                ", " + issue.message;
        }
    }
}
