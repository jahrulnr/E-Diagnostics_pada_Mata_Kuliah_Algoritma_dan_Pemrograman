package jahrulnr.e_diagnosticsuir.customBootstrap;

import android.content.Context;

import androidx.annotation.ColorInt;
import com.beardedhen.androidbootstrap.api.attributes.BootstrapBrand;
import jahrulnr.e_diagnosticsuir.R;

public class transparentBrand implements BootstrapBrand {
    @ColorInt private final int defaultFill;
    @ColorInt private final int defaultEdge;
    @ColorInt private final int defaultTextColor;
    @ColorInt private final int activeFill;
    @ColorInt private final int activeEdge;
    @ColorInt private final int activeTextColor;
    @ColorInt private final int disabledFill;
    @ColorInt private final int disabledEdge;
    @ColorInt private final int disabledTextColor;

    @SuppressWarnings("deprecation") public transparentBrand(Context context) {
        @ColorInt int transparent = context.getResources().getColor(R.color.transparent);
        defaultFill = transparent;
        defaultEdge = transparent;
        defaultTextColor = context.getResources().getColor(android.R.color.white);
        activeFill = transparent;
        activeEdge = transparent;
        activeTextColor = context.getResources().getColor(android.R.color.white);
        disabledFill = transparent;
        disabledEdge = transparent;
        disabledTextColor = context.getResources().getColor(R.color.white);
    }

    @Override public int defaultFill(Context context) {
        return defaultFill;
    }

    @Override public int defaultEdge(Context context) {
        return defaultEdge;
    }

    @Override public int defaultTextColor(Context context) {
        return defaultTextColor;
    }

    @Override public int activeFill(Context context) {
        return activeFill;
    }

    @Override public int activeEdge(Context context) {
        return activeEdge;
    }

    @Override public int activeTextColor(Context context) {
        return activeTextColor;
    }

    @Override public int disabledFill(Context context) {
        return disabledFill;
    }

    @Override public int disabledEdge(Context context) {
        return disabledEdge;
    }

    @Override public int disabledTextColor(Context context) {
        return disabledTextColor;
    }

    @Override public int getColor() {
        return defaultFill;
    }
}
